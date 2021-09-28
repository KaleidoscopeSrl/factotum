<?php

namespace Kaleidoscope\Factotum\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;


use Kaleidoscope\Factotum\FactotumServiceProvider;
use Kaleidoscope\Factotum\Database\Factories\UserFactory;
use Kaleidoscope\Factotum\Database\Factories\RoleFactory;
use Kaleidoscope\Factotum\Database\Factories\ProfileFactory;
use Kaleidoscope\Factotum\Database\Factories\MediaFactory;
use Kaleidoscope\Factotum\Models\User;
use Kaleidoscope\Factotum\Models\Role;

use Kaleidoscope\Factotum\Repositories\UserRepository;



class KaleidoscopeTestCase extends TestCase
{
	protected $loadEnvironmentVariables = true;

	use WithFaker;

	protected $userRepository;

	protected $baseApiUrl =  '/api/v1';

	public $token;

	public $actorEmail    = 'filippo@kaleidoscope.it';
	public $actorPassword = '12345678';
	public $actorRole     = 'admin';



	protected $paginateStructure = [
		'collection' => [],
		'pagination' => [
			'page',
			'perPage',
			'total',
			'totalPages'
		]
	];


	protected $mediaStructure = [
		'id',
		'user_id',
		'filename',
		'filename_webp',
		'thumb',
		'thumb_webp',
		'url',
		'url_webp',
		'mime_type',
		'width',
		'height',
		'size',
		'caption',
		'alt_text',
		'description',
		'created_at',
		'updated_at'
	];


	protected $profileStructure = [
		'id',
		'first_name',
		'last_name',
		'phone',
		'user_id',
		'privacy',
		'newsletter',
		'created_at',
		'updated_at'
	];


	protected $userStructure = [
		'id',
		'email',
		'email_verified_at',
		'role_id',
		'editable',
		'avatar',
		'created_at',
		'updated_at'
	];



	public function __construct( $name = null, array $data = [], $dataName = '' )
	{
		parent::__construct($name, $data, $dataName);

		$this->baseApiUrl = env('APP_URL') . '/api/v1';

		$this->userStructure['profile'] = $this->profileStructure;
	}

	public function setUp(): void
	{
		parent::setUp();

		if ( !$this->userRepository ) {
			$this->userRepository = app()->make( UserRepository::class );
		}
	}


	public function customActingAs()
	{
		$role = Role::where( 'role', $this->actorRole )->first();
		$user = User::where( 'role_id', $role->id )->first();

		return Sanctum::actingAs( $user );
	}


	protected function checkResponse( TestResponse $response, ?string $uri = '' )
	{
		if ( $uri ) {
			echo '[' . $response->getStatusCode() . '] - ' . $uri . "\n";
		}

		if ( $response->status() != 200 ) {
			echo '<pre>';
			print_r( $response->json() );
			die;
		}
	}


	protected function generateMediaData()
	{
		$mF = new MediaFactory();
		return $mF->definition();
	}


	protected function generateUserData()
	{
		$uF = new UserFactory();
		$pF = new ProfileFactory();

		return array_merge( $uF->definition(), $pF->definition() );
	}



	protected function getPackageProviders($app)
	{
		return [
			FactotumServiceProvider::class,
		];
	}

}