<?php

namespace FroalaEditor;

class S3 {

  /**
  *
  * @param config:
  *   (
  *     timezone => 'Europe/Bucharest',
  *     bucket => 'bucketName',
  *
  *     //http://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region
  *     region => 's3',
  *     keyStart => 'editor/',
  *     acl => 'public-read',
  *     accessKey => 'YOUR-AMAZON-S3-PUBLIC-ACCESS-KEY',
  *     secretKey => 'YOUR-AMAZON-S3-SECRET-ACCESS-KEY'
  *   )
  *
  * @return:
  *   {
  *     bucket: bucket,
  *     region: region,
  *     keyStart: keyStart,
  *     params: {
  *       acl: acl,
  *       policy: policy,
  *       'x-amz-algorithm': 'AWS4-HMAC-SHA256',
  *       'x-amz-credential': xAmzCredential,
  *       'x-amz-date': xAmzDate,
  *       'x-amz-signature': signature
  *     }
  *   }
  */

  public static function getHash($config) {

    // Check default region.
    $config['region'] = !empty($config['region']) ? $config['region'] : 'us-east-1';
    $config['region'] = $config['region'] == 's3' ? 'us-east-1' : $config['region'];

    // Set date timezone.
    date_default_timezone_set($config['timezone']);

    // Important variables that will be used throughout this example.
    $bucket = $config['bucket'];
    $region = $config['region'];
    $keyStart = $config['keyStart'];
    $acl = $config['acl'];

    // These can be found on your Account page, under Security Credentials > Access Keys.
    $accessKeyId = $config['accessKey'];
    $secret = $config['secretKey'];

    $dateString = date('Ymd');

    $credential = implode("/", array($accessKeyId, $dateString, $region, 's3/aws4_request'));
    $xAmzDate = $dateString . 'T000000Z';

    // Build policy.
    $policy = base64_encode(json_encode(array(
      // ISO 8601 - date('c'); generates uncompatible date, so better do it manually.
      'expiration' => date('Y-m-d\TH:i:s.000\Z', strtotime('+5 minutes')), // 5 minutes into the future.
      'conditions' => array(
        array('bucket' => $bucket),
        array('acl' => $acl),
        array('success_action_status' => '201'),
        array('x-requested-with' => 'xhr'),
        // Optionally control content type and file size
        // array('Content-Type' => 'application/pdf'),
        array('x-amz-algorithm' => 'AWS4-HMAC-SHA256'),
        array('x-amz-credential' => $credential),
        array('x-amz-date' => $xAmzDate),
        array('starts-with', '$key', $keyStart),
        array('starts-with', '$Content-Type', '') // Accept all files.
      )
    )));

    // Generate signature.
    $dateKey = hash_hmac('sha256', $dateString, 'AWS4' . $secret, true);
    $dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
    $dateRegionServiceKey = hash_hmac('sha256', 's3', $dateRegionKey, true);
    $signingKey = hash_hmac('sha256', 'aws4_request', $dateRegionServiceKey, true);
    $signature = hash_hmac('sha256', $policy, $signingKey, false);

    // Prepare response.
    $response = new \StdClass;
    $response->bucket = $bucket;
    $response->region = $region != 'us-east-1' ? 's3-' . $region : 's3';
    $response->keyStart = $keyStart;

    // Prepare params.
    $params = new \StdClass;
    $params->acl = $acl;
    $params->policy = $policy;
    $params->{'x-amz-algorithm'} = 'AWS4-HMAC-SHA256';
    $params->{'x-amz-credential'} = $credential;
    $params->{'x-amz-date'} = $xAmzDate;
    $params->{'x-amz-signature'} = $signature;

    // Set params in response.
    $response->params = $params;

    return $response;
  }
}

// Define alias.
class_alias('FroalaEditor\S3', 'FroalaEditor_S3');