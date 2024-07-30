<?php

	namespace Modules\User\Emails;

	use App\User;
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;

	class UserPermanentlyDelete extends Mailable
	{
		use Queueable, SerializesModels;

		const CODE = [
			'first_name'    => '[first_name]',
			'last_name'     => '[last_name]',
			'name'          => '[name]',
			'email'         => '[email]',
		];

		public $user;
		public $subject;
		public $content;

		public function __construct(User $user, $subject,$content)
		{
			$this->user = $user;
			$this->subject = $subject;
			$this->content = $content;
		}


		public function build()
		{
			if (empty($this->subject)) {
				$subject = __('[:site_name] Permanently Delete Account', ['site_name' => setting_item('site_title')]);
			} else {
				$subject = $this->replaceSubjectEmail($this->subject);
			}
				$body = $this->replaceContentEmail($this->content);
			return $this->subject($subject)->view('User::emails.user-permanently-delete')->with(['content' => $body]);
		}

		public function replaceSubjectEmail($subject)
		{
			if (!empty($subject)) {
				foreach (self::CODE as $item => $value) {
					if (method_exists($this, $item)) {
						$replace = $this->$item();
					} else {
						$replace = '';
					}
					$subject = str_replace($value, $replace, $subject);
				}
			}
			return $subject;
		}

		public function replaceContentEmail($content)
		{
			if (!empty($content)) {
				foreach (self::CODE as $item => $value) {
					$content = str_replace($value, @$this->user->$item, $content);
				}
			}
			return $content;
		}

	}
