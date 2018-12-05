<?php

namespace Khatfield\LaravelSalesforce;

use Illuminate\Support\Facades\Facade;

/**
 * Class SalesforceFacade
 * @package Khatfield\LaravelSalesforce

 * @method static void addHeader( $header)
 * @method static \Khatfield\SoapClient\Result\LeadConvertResult convertLead(array $leadConverts)
 * @method static \Khatfield\SoapClient\Result\EmptyRecycleBinResult[] emptyRecycleBin(array $ids)
 * @method static \Khatfield\SoapClient\Result\SaveResult[] create(array $objects,  $type)
 * @method static \Khatfield\SoapClient\Result\DeleteResult delete(array $ids)
 * @method static \Khatfield\SoapClient\Result\DescribeGlobalResult describeGlobal()
 * @method static \Khatfield\SoapClient\Result\DescribeSObjectResult[] describeSObjects(array $objects)
 * @method static \Khatfield\SoapClient\Result\DescribeTabSetResult[] describeTabs()
 * @method static \Khatfield\SoapClient\Result\GetDeletedResult getDeleted(string $objectType, \DateTime $startDate, \DateTime $endDate)
 * @method static \Khatfield\SoapClient\Result\GetUpdatedResult getUpdated(string $objectType, \DateTime $startDate, \DateTime $endDate)
 * @method static \Khatfield\SoapClient\Result\GetUserInfoResult getUserInfo()
 * @method static \Khatfield\SoapClient\Result\LoginResult login(string $username, string $password, string $token)
 * @method static \Khatfield\SoapClient\Result\LoginResult getLoginResult()
 * @method static void logout()
 * @method static \Khatfield\SoapClient\Result\MergeResult merge(array $mergeRequests,string  $type)
 * @method static \Khatfield\SoapClient\Result\RecordIterator query(string $query)
 * @method static \Khatfield\SoapClient\Result\RecordIterator queryAll(string $query)
 * @method static \Khatfield\SoapClient\Result\QueryResult queryMore(string $queryLocator)
 * @method static \Khatfield\SoapClient\Result\SObject[] retrieve(array $fields, array $ids, string $objectType)
 * @method static \Khatfield\SoapClient\Result\SearchResult search(string $searchString)
 * @method static \Khatfield\SoapClient\Result\UndeleteResult undelete(array $ids)
 * @method static \Khatfield\SoapClient\Result\UpsertResult update(array $objects, string $type)
 * @method static \Khatfield\SoapClient\Result\UpsertResult upsert( $externalIdFieldName, array $objects, string $type)
 * @method static \Khatfield\SoapClient\Result\GetServerTimestampResult getServerTimestamp()
 * @method static \Khatfield\SoapClient\Result\SendEmailResult sendEmail(array $emails)
 * @method static array setPassword(string $userId,string $password)
 */
class SalesforceFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'salesforce';
    }
}