<?php

namespace Modules\Review\Controllers;

use App\Helpers\ReCaptchaEngine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Events\CreateReviewEvent;
use Modules\Review\Models\Review;
use Modules\Review\Models\ReviewMeta;
use Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
    }

    public function addReview(Request $request, $is_return = false)
    {
        $service_type = $request->input('review_service_type');
        $service_id = $request->input('review_service_id');
        $review_upload = $request->input('review_upload', []);

        $allServices = get_reviewable_services();

        if (empty($allServices[$service_type])) {
            if ($is_return) {
                return $this->sendError(__("Service type not found"));
            } else {
                return redirect()->to(url()->previous() . '#review-form')->with('error', __('Service type not found'));
            }
        }

        $module_class = $allServices[$service_type];
        $module = $module_class::find($service_id);
        if (empty($module)) {
            if ($is_return) {
                return $this->sendError(__("Service not found"));
            } else {
                return redirect()->to(url()->previous() . '#review-form')->with('error', __('Service not found'));
            }
        }
        $reviewEnable = $module->getReviewEnable();
        if (!$reviewEnable) {
            if ($is_return) {
                return $this->sendError(__("Review not enable"));
            } else {
                return redirect()->to(url()->previous() . '#review-form')->with('error', __('Review not enable'));
            }
        }

        if ($module->review_after_booking()) {
            if (!$module->count_remain_review()) {
                if ($is_return) {
                    return $this->sendError(__("You need to make a booking or the Orders must be confirmed before writing a review"));
                } else {
                    return redirect()->to(url()->previous() . '#review-form')->with('error', __('You need to make a booking or the Orders must be confirmed before writing a review'));
                }
            }
        }

        if ($module->author_id == Auth::id()) {
            if ($is_return) {
                return $this->sendError(__("You cannot review your service"));
            } else {
                return redirect()->to(url()->previous() . '#review-form')->with('error', __('You cannot review your service'));
            }
        }

        $rules = [
            'review_title'   => 'required',
            'review_content' => 'required|min:10'
        ];
        $messages = [
            'review_title.required'   => __('Review Title is required field'),
            'review_content.required' => __('Review Content is required field'),
            'review_content.min'      => __('Review Content has at least 10 character'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            if ($is_return) {
                return $this->sendError($validator->errors());
            } else {
                return redirect()->to(url()->previous() . '#review-form')->withErrors($validator->errors());
            }
        }

        if (ReCaptchaEngine::isEnable()) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                $data = [
                    'status'  => 0,
                    'message' => __('Please verify the captcha'),
                ];
                return response()->json($data, 200);
            }
        }

        $all_stats = setting_item($service_type . "_review_stats");
        $review_stats = $request->input('review_stats');
        $metaReview = [];
        if (!empty($all_stats)) {
            $all_stats = json_decode($all_stats, true);
            $total_point = 0;
            foreach ($all_stats as $key => $value) {
                if (isset($review_stats[$value['title']])) {
                    $total_point += $review_stats[$value['title']];
                }
                $metaReview[] = [
                    "object_id"    => $service_id,
                    "object_model" => $service_type,
                    "name"         => $value['title'],
                    "val"          => $review_stats[$value['title']] ?? 0,
                ];
            }
            $rate = round($total_point / count($all_stats), 1);
            if ($rate > 5) {
                $rate = 5;
            }
        } else {
            $rate = $request->input('review_rate');
        }
        if (setting_item('review_upload_picture') && !empty($review_upload)) {
            $metaReview[] = [
                "object_id"    => $service_id,
                "object_model" => $service_type,
                "name"         => 'upload_picture',
                "val"          => json_encode($review_upload)
            ];
        }
        $review = new Review([
            "object_id"    => $service_id,
            "object_model" => $service_type,
            "title"        => $request->input('review_title'),
            "content"      => $request->input('review_content'),
            "rate_number"  => $rate ?? 0,
            "author_ip"    => $request->ip(),
            "status"       => !$module->getReviewApproved() ? "approved" : "pending",
            'vendor_id'    => $module->author_id,
            'author_id'    => Auth::id(),
        ]);
        if ($review->save()) {
            if (!empty($metaReview)) {
                foreach ($metaReview as $meta) {
                    $meta['review_id'] = $review->id;
                    $reviewMeta = new ReviewMeta($meta);
                    $reviewMeta->save();
                }
            }
            $images = $request->input('review_upload');
            if (is_array($images) and !empty($images)) {
                foreach ($images as $image) {
                    if (!$this->validateUploadImage($image)) continue;
                    $review->addMeta('review_image', $image, true);
                }
            }

            $msg = __('Review success!');
            if ($module->getReviewApproved()) {
                $msg = __("Review success! Please wait for admin approved!");
            }
            event(new CreateReviewEvent($module, $review));
            $module->update_service_rate();
            if ($is_return) {
                return $this->sendSuccess($msg);
            } else {
                return redirect()->to(url()->previous() . '#bravo-reviews')->with('success', $msg);
            }
        }
        if ($is_return) {
            return $this->sendError(__('Review error!'));
        } else {
            return redirect()->to(url()->previous() . '#review-form')->with('error', __('Review error!'));
        }
    }

    protected function validateUploadImage($image)
    {

        if (empty($image['file_extension'])) return false;
        if (!in_array(strtolower($image['file_extension']), ['png', 'jpg', 'jpeg', 'gif', 'bmp'])) return;

        if (empty($image['file_type'])) return false;
        if (strpos(strtolower($image['file_type']), 'image/') !== 0) return false;

        return true;
    }
}
