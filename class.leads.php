<?php
require_once('class.baseclient.php');

class Leads extends BaseClient {
    //Client for HubSpot Leads API.

    //Define required client variables
    protected $API_PATH = 'leads';    
    protected $API_VERSION = 'v1';

    /**
    * Get a list of leads
    *
    * @param params: Array of Leads API query filters and values 
    *                See http://docs.hubapi.com/wiki/Searching_Leads for valid filters and values
    *
    * @returns Array of Leads as stdObjects
    *
    * @throws exception
    **/
    public function get_leads($params) {
        $endpoint = 'list';
        try {
            return json_decode($this->execute_get_request($this->get_request_url($endpoint,$params))); 
        } catch (Exception $e) {
            throw new Exception('Unable to retrieve list: ' . $e);
        }
 
    }

    /**
    * Get a single lead
    *
    * @param leadGuid: String value of the guid for the lead to return
    *
    * @returns single Lead as stdObject
    *
    * @throws exception
    **/
    public function get_lead($leadGuid) {
        $endpoint = 'lead/' . $leadGuid;
        try {
            $leadArray = json_decode('[' . $this->execute_get_request($this->get_request_url($endpoint,null)) . ']');
            return $leadArray[0];
        } catch (Exception $e) {
            throw new Exception('Unable to retrieve lead: ' . $e);
        }
    } 
    
    /**
    * Update a single lead
    *
    * @param leadGuid: String value of the guid for the lead to update
    * @param updateData: Array of fields and values to update
    *
    * @returns Response body from HTTP PUT request
    *
    * @throws exception
    **/
    public function update_lead($leadGuid, $updateData) {
        $endpoint = 'lead/' . $leadGuid;
        $updateData['id'] = $leadGuid;
        $body = json_encode($updateData);
        try {
            return $this->execute_put_request($this->get_request_url($endpoint,null), $body);
        } catch (Exception $e) {
            throw new Exception('Unable to update lead: ' . $e); 
        }
    }

    /**
    * Update a single lead to a customer
    *
    * @param leadGuid: String value of the guid for the lead to update
    * @param closeDate: String value of the close date/time in ms since epoch
    *
    * @returns Response body from HTTP PUT request
    *
    * @throws exception
    **/
    public function close_lead($leadGuid, $closeDate) {
        $endpoint = 'lead/' . $leadGuid;
        $updateData = array();
        $updateData['id'] = $leadGuid;
        $updateData['closedAt'] = $closeDate;
        $updateData['isCustomer'] = 'true';
        $body = json_encode($updateData);
        try {
            return $this->execute_put_request($this->get_request_url($endpoint,null), $body);
        } catch (Exception $e) {
            throw new Exception('Unable to close lead: ' . $e);
        }
    }

    /**
    * Adds a single lead to HubSpot via the Lead Tracking API
    *
    * @param formURL: String value fo the form URL to POST to
    * @param postFields: Array of fields and values to post to HubSpot
    *
    * @returns Response body from HTTP PUT request
    *
    * @throws exception
    **/
    public function add_lead($formURL, $postFields) {
        try {
            return $this->execute_post_request($formURL, $postFields);
        } catch (Exception $e) {
            throw new Exception('Unable to add lead: ' . $e);
        }   
    }

    public function get_webhook() {

    }

    public function register_webhook() {

    } 

}