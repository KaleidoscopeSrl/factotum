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

    public function __construct( $campaignTemplate, $campaignEmail = null )
    {
    	if ( $campaignEmail ) {
    		$this->_campaignEmail = $campaignEmail;
		}

    	$this->_campaignTemplate = $campaignTemplate;
    	$this->_subject          = $this->_campaignTemplate->subject;

		$this->_viewData['demContent'] = $this->_parseContent( $this->_campaignTemplate->content );
    }


    public function setUser( $user )
	{
		$this->_user = $user;
	}


	private function _addAttachments($email)
	{
		$attachments= CampaignAttachment::where( 'campaign_template_id', $this->_campaignTemplate->id )->get();

		if ( $attachments->count() > 0 ) {
			foreach ( $attachments as $attach ) {
				// TODO: qui modificare con file da media
				// $email->attach( public_path( parse_url($attach->url, PHP_URL_PATH) ) );
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
			$view = 'email.campaign.campaign_email';
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

			if ( $this->_user ) {
				$subject = str_replace('{FIRST_NAME}', $this->_user->profile->first_name, $subject);
				$subject = str_replace('{LAST_NAME}',  $this->_user->profile->last_name, $subject);
			}

			return $subject;
		}

		return $defaultSubject;
	}


	protected function _parseContent($demContent)
	{
		if ( $this->_user ) {
			$demContent = str_replace('{FIRST_NAME}',      $this->_user->profile->first_name,                 $demContent);
			$demContent = str_replace('{LAST_NAME}',       $this->_user->profile->last_name,                  $demContent);
		}

		return $demContent;
	}

}
