<?php
/*

Plugin Name:  Contact Form 7 Bigmarker Integration
Description:  Create a new form field that pulls all available webinars and registers submissions.
Version:      1.0
Author:       @cjcodes
Author URI:   https://cj.codes

*/

// TODO SORT BY DATE
class CF7Bigmarker {
  const BIGMARKER_URL = 'https://www.bigmarker.com/api/v1/';
  const DATE_FORMAT = 'l, F j, Y g:ia T';

  function __construct() {
    add_action('wpcf7_init', array($this, 'addTag'));
    add_action('wpcf7_before_send_mail', array($this, 'submissionHandler'));
    add_action('wpcf7_posted_data', array($this, 'dateValueAdder'));
  }

  public function addTag() {
    wpcf7_add_form_tag('bigmarker', array($this, 'tagHandler'), array('name-attr' => true));
  }

  public function tagHandler($tag) {
    $channel = $this->parseOptions($tag->options)['channel'];
    $conferences = $this->get('conferences')->conferences;

    $output = [];
    foreach ($conferences as $conference) {
      if ($conference->channel_id == $channel) {
        $time = new DateTime($conference->start_time);
        $output[$conference->id] = $time->setTimezone(new DateTimeZone('America/New_York'));
      }
    }

    $return = '';
    foreach ($output as $id => $time) {
      $return .= '<label><input name="cf7-bm-webinar" value="'.$id.'" type="radio" /><span class="wpcf7-list-item-label">'.$time->format(self::DATE_FORMAT).'</span></label>';
    }

    return $return;
  }

  protected function get($route) {
    $path = self::BIGMARKER_URL . $route;

    $resp = wp_remote_get($path, [
      'headers' => [
        'API-KEY' => BIGMARKER_API_KEY,
      ],
    ]);

    return json_decode($resp['body']);
  }

  protected function post($route, $body) {
    $path = self::BIGMARKER_URL . $route;

    $resp = wp_remote_post($path, [
      'body' => $body,
      'headers' => [
        'API-KEY' => BIGMARKER_API_KEY,
      ],
    ]);

    return json_decode($resp['body']);
  }

  public function dateValueAdder($data) {
    if (isset($data['cf7-bm-webinar'])) {
      $webinar = $data['cf7-bm-webinar'];

      $conference = $this->get('conferences/'.$webinar);
      $time = new DateTime($conference->start_time);
      $time = $time->setTimezone(new DateTimeZone('America/New_York'));

      $tags = wpcf7_scan_form_tags();
      foreach ($tags as $tag) {
        if ($tag->type == 'bigmarker') {
          $data[$tag->name] = $time->format(DATE_ATOM);
          break;
        }
      }
    }
  }

  public function submissionHandler($cf7) {
    if (!defined('BIGMARKER_API_KEY')) {
      return;
    }

    $data = WPCF7_Submission::get_instance()->get_posted_data();

    $tag = null;
    foreach (wpcf7_scan_form_tags($cf7) as $tag) {
      if ($tag->type == 'bigmarker') {
        break;
      }
    }

    if (!is_null($tag)) {
      if (empty($data['cf7-bm-webinar'])) {
        return;
      }

      $opts = $this->parseOptions($tag->options);

      $this->post('conferences/register', [
        'email' => $data[$opts['email']],
        'first_name' => $data[$opts['first']],
        'last_name' => $data[$opts['last']],
        'id' => $data['cf7-bm-webinar']
      ]);
    }
  }

  protected function parseOptions($options) {
    $return = [];

    foreach ($options as $option) {
      $arr = explode(':', $option);
      $return[$arr[0]] = $arr[1];
    }

    return $return;
  }
}

new CF7Bigmarker;
