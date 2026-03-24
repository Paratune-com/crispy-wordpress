<?php
/**
 * Theme functions and definitions.
 */
		 
		 /**
 * Class Elementor_Form_Email_Attachments
 *
 * Send Elementor Form upload field as attachments to email
 */
class Elementor_Form_Email_Attachments {
   public $attachments_array = [];

   public function __construct() {
      add_action( 'elementor_pro/forms/process', [ $this, 'init_form_email_attachments' ], 11, 2 );
   }

   /**
    * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
    * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
    */
   public function init_form_email_attachments( $record, $ajax_handler ) {
      // check if we have attachments
      $files = $record->get( 'files' );
      if ( empty( $files ) ) {
         return;
      }
      // Store attachment in local var
      foreach ( $files as $id => $files_array ) {
         $this->attachments_array[] = $files_array['path'][0];
      }

      // if local var has attachments setup filter hook
      if ( 0 < count( $this->attachments_array ) ) {
         add_filter( 'wp_mail', [ $this, 'wp_mail' ] );
         add_action( 'elementor_pro/forms/new_record', [ $this, 'remove_wp_mail_filter' ], 5 );
      }
   }

   public function remove_wp_mail_filter() {
      $this->attachments_array = [];
      remove_filter( 'wp_mail', [ $this, 'wp_mail' ] );
   }

   public function wp_mail( $args ) {
      $args['attachments'] = $this->attachments_array;
      return $args;
   }
}
new Elementor_Form_Email_Attachments();