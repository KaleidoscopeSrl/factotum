<?php

namespace Kaleidoscope\Factotum\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

use Kaleidoscope\Factotum\CampaignAttachment;


class CampaignEmail extends Mailable implements ShouldQueue
{
	private $_user;
	private $_campaignTemplate;
	private $_campaignEmail;

	private $_subject;

	protected $_viewData;

    public function __construct( $user, $campaignTemplate, $campaignEmail = null )
    {
    	if ( $campaignEmail ) {
    		$this->_campaignEmail = $campaignEmail;
		}

    	$this->_user             = $user;
    	$this->_campaignTemplate = $campaignTemplate;
    	$this->_subject          = $this->_campaignTemplate->subject;

    	$this->_prepareHeader();

		$this->_viewData['demContent'] = $this->_parseContent( $this->_campaignTemplate->content );
    }


	private function _prepareHeader()
	{
		// LOGO
		if ( $this->_campaignTemplate->logo ) {
			$this->_viewData['demLogo'] = url( $this->_campaignTemplate->logo );
		} else {
			$this->_viewData['demLogo'] = null;
		}

		$this->_viewData['hideDemLogo'] = $this->_campaignTemplate->hide_logo;


		// TITLE
		if ( $this->_campaignTemplate->title ) {
			$this->_viewData['demTitle'] = $this->_campaignTemplate->title;
		}


		// IMAGE
		if ( $this->_campaignTemplate->cover ) {
			$this->_viewData['demImage'] = url( $this->_campaignTemplate->cover );
		} else {
			$this->_viewData['demImage'] = null;
		}
	}


	private function _addAttachments($email)
	{
		$attachments= CampaignAttachment::where( 'campaign_template_id', $this->_campaignTemplate->id )->get();

		if ( $attachments->count() > 0 ) {
			foreach ( $attachments as $attach ) {
				$email->attach( public_path( parse_url($attach->url, PHP_URL_PATH) ) );
			}
		}

		return $email;
	}


    public function build()
    {
    	if ( $this->_campaignEmail ) {
			$this->withSwiftMessage(function ($message) {
				$message->getHeaders()
					->addTextHeader('X-Mailgun-Variables', '{"campaign_email_id": "' . $this->_campaignEmail->id . '"}');
			});
		}

		$view = 'factotum::email.campaign.campaign_email';

		if ( file_exists( resource_path('views/email/campaign/campaign_email.blade.php') ) ) {
			$view = 'notifications.new_order';
		}


		$email = $this->subject( $this->_subject )
						->markdown( $view, $this->_viewData );

		$email = $this->_addAttachments( $email );

		return $email;
    }


	protected function _parseSubject($subject, $defaultSubject = '')
	{
		if ( $subject != '' ) {
			$subject = strip_tags($subject);
			$subject = str_replace('{FIRST_NAME}', $this->_user->profile->first_name, $subject);
			$subject = str_replace('{LAST_NAME}',  $this->_user->profile->last_name, $subject);

			return $subject;
		}

		return $defaultSubject;
	}


	protected function _parseContent($demContent)
	{
		$demContent = str_replace('{FIRST_NAME}',      $this->_user->profile->first_name,                 $demContent);
		$demContent = str_replace('{LAST_NAME}',       $this->_user->profile->last_name,                  $demContent);

		return $demContent;
	}

}
