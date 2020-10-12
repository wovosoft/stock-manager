<?php


use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            "site_name" => "WovoPOS",
            "phone" => "123456789",
            "email" => "example@email.com",
            "address" => "Example, Address-5400, Bangladesh",
            "currency" => "BDT",
            "locale" => "en-US",
            "default_discount" => 0,
            "default_tax" => 0,
            "default_customer" => 1,
            "send_sms_after_sale" => false,
            "send_sms_after_order" => false,
            "logo" => null,
            "timezone" => "Asia/Dhaka",
            "language" => 1,
            "invoice_header" => "",
            "invoice_footer" => "",
        ];
        foreach ($settings as $key => $value) {
            $s = new \App\Models\Setting();
            $s->key = $key;
            $s->value = $value;
            $s->saveOrFail();
        }
    }
}
