<?php
namespace  Modules\User;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        $wallet =
            [
                'id'        => 'wallet',
                'title'     => __("Wallet Settings"),
                'position'  => 50,
                'view'      => "User::admin.settings.wallet",
                "keys"      => [
                    'wallet_module_disable',

                    'wallet_credit_exchange_rate',
                    'wallet_deposit_type',
                    'wallet_deposit_rate',
                    'wallet_deposit_lists',

                    'wallet_new_deposit_admin_subject',
                    'wallet_new_deposit_admin_content',
                    'wallet_new_deposit_customer_subject',
                    'wallet_new_deposit_customer_content',

                    'wallet_update_deposit_admin_subject',
                    'wallet_update_deposit_admin_content',
                    'wallet_update_deposit_customer_subject',
                    'wallet_update_deposit_customer_content',
                ],
                'html_keys' => [

                ]
            ];
        return [
            [
                'id'   => 'user',
                'title' => __("User Settings"),
                'position'=>50,
                'view'=>"User::admin.settings.user",
                "keys"=>[
                    'user_enable_login_recaptcha',
                    'user_enable_register_recaptcha',
                    'enable_mail_user_registered',
                    'user_content_email_registered',
                    'admin_enable_mail_user_registered',
                    'admin_content_email_user_registered',
                    'user_content_email_forget_password',
                    'inbox_enable',
                    'subject_email_verify_register_user',
                    'content_email_verify_register_user',
                    'user_disable_verification_feature',
                    'enable_verify_email_register_user',
                    'user_enable_2fa',

                    'user_enable_permanently_delete',
                    'user_permanently_delete_content',
                    'user_permanently_delete_content_confirm',

                    'user_enable_permanently_delete_email',
                    'user_permanently_delete_subject_email',
                    'user_permanently_delete_content_email',

                    'user_permanently_delete_subject_email_to_admin',
                    'user_permanently_delete_content_email_to_admin',

                    'user_disable_register',
                    'user_role'

                ],
                'html_keys'=>[

                ]
            ],
            [
                'id'   => 'user_plans',
                'title' => __("User Plans Settings"),
                'position'=>51,
                'view'=>"User::admin.settings.plan",
                "keys"=>[
                    'user_plans_enable',

                    'user_plans_page_title',
                    'user_plans_page_sub_title',
                    'user_plans_sale_text',
                    'enable_multi_user_plans',

                    'plan_new_payment_admin_enable',
                    'plan_new_payment_admin_subject',
                    'plan_new_payment_admin_content',

                    'plan_update_payment_admin_enable',
                    'plan_update_payment_admin_subject',
                    'plan_update_payment_admin_content',

                    'plan_new_payment_user_enable',
                    'plan_new_payment_user_subject',
                    'plan_new_payment_user_content',

                    'plan_update_payment_user_enable',
                    'plan_update_payment_user_subject',
                    'plan_update_payment_user_content',
                ],
                'html_keys'=>[

                ]
            ],
            $wallet
        ];
    }
}
