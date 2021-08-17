<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert("INSERT INTO `settings` ( `label`, `name`, `status`, `value`, `ord`, `created_at`, `updated_at`) VALUES
        ('Setting_general', 'admin_default_language', 1, 'tr', 0, now(), now()),
        ('Setting_general', 'client_default_language', 1, 'tr', 1, now(), now()),
        ('Setting_general', 'admin_email', 1, 'online@jeordies.com.tr', 5, now(), now()),
        ('Setting_general', 'site_name', 1, 'Jeordie\'s', 3, now(), now()),
        ('Setting_social_configuration', 'Twitter link', 1, 'https://twitter.com/jeordiesmenwear', 0, now(), now()),
        ('Setting_social_configuration', 'Instagram link', 1, 'https://www.instagram.com/jeordiesmen/', 0, now(), now()),
        ('Setting_social_configuration', 'Facebook link', 1, 'https://www.facebook.com/jeordies.com.tr', 0, now(), now()),
        ('Setting_social_configuration', 'Appstore link', 1, '#', 4, now(), now()),
        ('Setting_general', 'Theme Layout', 1, 'left', 33, now(), now()),
        ('Setting_general', 'image_optimise_key', 1, '4fF8ppcvGukp3zWiFJws-BFvHdeyICOn', 34, now(), now()),
        ('Setting_social_configuration', 'Facebook id', 1, '829390498015153', 0, now(), now()),
        ('Setting_general', 'site_url', 1, 'https://www.jeordiesmen.com', 2, now(), now()),
        ('Setting_server_API', 'remote_image_url', 1, 'http://77.75.32.138:1953/', 0, now(), now()),
        ('Setting_social_configuration', 'instagram_access_token', 1, '', 0, now(), now()),
        ('Setting_social_configuration', 'instagram_home_count', 1, '4', 8, now(), now()),
        ('Setting_ecommerce_function', 'Filter_price_min', 1, '0', 0, now(), now()),
        ('Setting_ecommerce_function', 'Filter_price_max', 1, '1000', 0, now(), now()),
        ('Setting_ecommerce_function', 'Filter_price_range', 1, '200', 0, now(), now()),
        ('Setting_ecommerce_function', 'Tax', 1, '0', 0, now(), now()),
        ('Setting_server_API', 'remote_api_url', 1, 'http://77.75.32.138:1953/index.php', 0, now(), now()),
        ('Setting_ecommerce_function', 'discount_prefix', 1, 'jeordies', 0, now(), now()),
        ('Setting_ecommerce_function', 'cargo_price', 1, '20', 0, now(), now()),
        ('Setting_ecommerce_function', 'cash_on_delivery_price', 1, '9', 0, now(), now()),
        ('Setting_general', 'is_live_mode', 0, '1', 4, now(), now()),
        ('Setting_newsletter_type', 'Newsletter', 1, 'Front newsletter', 0, now(), now()),
        ('Setting_newsletter_type', 'Buyer', 1, 'Buyer', 0, now(), now()),
        ('Setting_general', 'url_prefix', 1, 'https://', 30, now(), now()),
        ('address_type', 'Home', 1, 'Home Address', 0, now(), now()),
        ('address_type', 'Office', 1, 'Samoborska Cesta 145 E , Zagreb', 0, now(), now()),
        ('Setting_ecommerce_function', 'site_cart_cookie', 1, 'jeo_cart', 0, now(), now()),
        ('Setting_ecommerce_function', 'site_address_cookie', 1, 'jeo_address', 0, now(), now()),
        ('Setting_ecommerce_function', 'exchange_rate', 1, '0.5', 0, now(), now()),
        ('Setting_ecommerce_function', 'cargo_price_min', 1, '299', 0, now(), now()),
        ('Setting_ecommerce_function', 'instagram_home_count', 1, '8', 0, now(), now()),
        ('Setting_social_configuration', 'Google client id', 1, '', 0, now(), now()),
        ('Setting_general', 'Page title postfix', 1, '| Jeordie\'s', 7, now(), now()),
        ('Setting_general', 'Mobile format', 1, '+', 8, now(), now()),
        ('Setting_general', 'sf_upload_dir', 0, 'uploads', 31, now(), now()),
        ('Setting_order_email', 'Jeordies', 0, 'online@jeordies.com.tr', 0, now(), now()),
        ('Setting_general', 'default_image_color', 1, '#C1A9A5', 32, now(), now()),
        ('Setting_contact_email', 'Jeordies', 0, 'jeordies@jeordies.com.tr', 0, now(), now()),
        ('Setting_general', 'Email_key', 1, '2b918a3de468219991c70b5104835005', 9, now(), now()),
        ('Setting_general', 'Image_max_size_MB', 1, '1', 35, now(), now()),
        ('Setting_general', 'Visa_url', 1, 'https://www.visa.com.hr/', 29, now(), now()),
        ('Setting_general', 'Master_url', 1, 'https://www.mastercard.com.tr/tr-tr.html', 44, now(), now()),
        ('Setting_general', 'Maestro_url', 1, 'http://www.maestrocard.com/', 39, now(), now()),
        ('Setting_general', 'American_url', 1, 'https://www.americanexpress.com/hr/network/', 41, now(), now()),
        ('Setting_general', 'Dinner_url', 1, 'https://www.diners.hr/hr', 43, now(), now()),
        ('Setting_general', 'Visa_Verify_url', 1, 'https://www.zaba.hr/download/ecommerce/verified_by_visa.htm', 40, now(), now()),
        ('Setting_general', 'Master_Secure_url', 1, 'https://www.zaba.hr/download/ecommerce/master_securecode.htm', 42, now(), now()),
        ('Setting_general', 'map_key', 1, 'AIzaSyC_E7K2rsB7EiPk9MEbLdRD05I7gunlwjI', 12, now(), now()),
        ('Setting_general', 'customer_first_order_discount_code', 1, 'jeordies202020202020', 13, now(), now()),
        ('Setting_general', 'ios_app_version', 1, '1.0', 14, now(), now()),
        ('Setting_general', 'android_app_version', 1, '1.0', 15, now(), now()),
        ('Setting_general', 'ios_force_update', 1, '0', 16, now(), now()),
        ('Setting_general', 'android_force_update', 1, '0', 17, now(), now()),
        ('Setting_general', 'appstore_link', 1, 'https://play.google.com/store/apps?hl=en', 18, now(), now()),
        ('Setting_general', 'playstore_link', 1, 'https://play.google.com/store?hl=en', 19, now(), now()),
        ('Setting_general', 'paypal_account', 1, 'sandbox', 20, now(), now()),
        ('Setting_general', 'country_id', 1, '53', 21, now(), now()),
        ('Setting_general', 'static_image_module', 1, 'Home Popup, Login, Signup, Forget, Reset Pass, Store, Cart, Return form, Account for all, Order step Profile, Order step address, Order step bank, Order step Detail, Combination, Campaign', 22, now(), now()),
        ('Setting_general', 'Popup_timeout', 1, '500000', 23, now(), now()),
        ('Setting_ecommerce_function', 'product_stock_check', 1, '1', 0, now(), now()),
        ('Setting_general', 'Return_order_value', 1, 'I did not like the product, Different than it looks on the site, Wrong product, Size problem, Defective product, The color of the product is different from the photo, The product arrived late, The product is missing, The right to withdraw', 24, now(), now()),
        ('Setting_general', 'is_google_captcha_on', 1, '1', 25, now(), now()),
        ('Setting_return_order_email', 'ured@jeordies.com.tr', 0, 'ured@jeordies.com.tr', 0, now(), now()),
        ('Setting_general', 'is_product_list_color_base', 1, '1', 26, now(), now()),
        ('Setting_general', 'assets_version', 1, '1.4', 6, now(), now()),
        ('Setting_order_email', 'Jeordie\'s Admin', 1, 'selim@jeordies.com.tr', 0, now(), now()),
        ('Setting_contact_email', 'Contact\'tan gelen mailler', 0, 'ured@jeordies.com.tr', 0, now(), now()),
        ('Setting_general', 'captcha_style', 1, 'google', 36, now(), now()),
        ('Setting_return_order_email', 'Online', 1, 'online@jeordies.com.tr', 95, now(), now()),
        ('Setting_contact_email', 'Online', 1, 'online@jeordies.com.tr', 96, now(), now()),
        ('Setting_order_email', 'serife', 0, 'serife@ketencek.com', 98, now(), now()),
        ('Setting_general', 'captcha_g3_sitekey', 1, '6Lc85yUaAAAAAMlrnJGtde9JwssSQjWNfjZXvJKK', 99, now(), now()),
        ('Setting_general', 'captcha_g3_secretkey', 1, '6Lc85yUaAAAAAF5wz29UMMu_S0t_Z7joCztH7J5-', 100, now(), now()),
        ('Setting_general', 'default_currency', 1, 'try', 108, now(), now()),
        ('Setting_server_API', 'remote_api_url_v3', 1, 'http://77.75.32.138:9191/IntegratorService', 114, '2021-04-15 15:34:55', '2021-05-20 15:54:57')");

        Setting::saveConfig();
    }
}
