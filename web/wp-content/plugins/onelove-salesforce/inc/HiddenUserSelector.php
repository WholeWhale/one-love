<?php

class HiddenUserSelector {
  public function addTag() {
    wpcf7_add_form_tag('sfuser', array($this, 'tagHandler'), array('name-attr' => true));
  }

  public function tagHandler($tag) {
    if ($user = ContactChecker::getContactInfo()) {
      $name = $tag->name;
      if (!$name) {
        $name = 'contactId';
      }

      $value = ($name == 'Id') ? $user->Id : $user->fields->{$name};

      return '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
    } else {
      return 'Unable to find Salesforce user id. Is the "Salesforce contact" gate turned on for this post?';
    }
  }
}
