<?php
class Product_test extends TestCase
{
    public function test_index()
    {
        $output = $this->request('GET', 'product/index');
        // Check title
        $this->assertContains('<title>Product List</title>', $output);
    }

    public function test_api_create(){
      // $image_b64_i = fopen('https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png', 'r');
      // $image_b64_i = file_get_contents("https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png");
      // $image_b64 = ('data:image;base64,' . $image_b64_i);
      $r = $this->ajaxRequest('POST', 'product/api_create/', [
          'name' => "PRODUCT NAME",
          'price' => 101,
          'desc' => "Check string",
          // 'image' => $image_b64_i
      ]);
      // check return json key
      $ajax_return = json_decode($r, TRUE);
      $this->assertArrayHasKey('isError', $ajax_return);
      $this->assertArrayHasKey('msg', $ajax_return);
    }

    public function test_api_edit(){
      // Need HTT_REFERER to get product_id
      $this->resetInstance();
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, base_url('product/api_edit'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_REFERER, base_url('product/edit_product/1'));
      $html = curl_exec($ch);

      $ajax_return = json_decode($html, TRUE);
      $this->assertArrayHasKey('isError', $ajax_return);
      $this->assertArrayHasKey('msg', $ajax_return);
      // Return error or not (isError = FALSE = ok)
      // $this->assertFalse($ajax_return['isError']);
      // $this->assertArrayHasKey(200);
    }

    public function test_api_delete(){
      // $image_b64_i = file_get_contents("https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png");
      // $image_b64 = ('data:image;base64,' . $image_b64_i);
      $r = $this->ajaxRequest('POST', 'product/api_delete/', [
          'product_id' => 1,
          'status' => 1
      ]);
      // check return json key
      $ajax_return = json_decode($r, TRUE);
      $this->assertArrayHasKey('isError', $ajax_return);
      $this->assertArrayHasKey('msg', $ajax_return);
    }
}
