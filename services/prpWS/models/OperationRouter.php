<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OperationRouter
 *
 * @author gabriel
 */
class OperationRouter
{
    protected $oDb;
    protected $oSession;
    protected $sXml;

    public function __construct(OperationRouterDTO $dto)
    {
        $this->oDb      = $dto->oDb;
        $this->oSession = $dto->oSession;
        $this->sXml     = $dto->sXml;
    }

    /**
     *  <parameters>
     *      <operation></operation>
     *      <entity></entity>
     *      <date></date>
     *      <category></category>
     *      <paymentSource></paymentSource>
     *      <store></store>
     *      <amount></amount>
     *      <installments></installments>
     *      <lifeCost></lifeCost>
     *      <directDebit></directDebit>
     *      <comment></comment>
     *  </parameters>
     *
     */
    public function handle()
    {
        try {
            $oXml = simplexml_load_string($this->sXml);
            
            if (!$oXml) {
                throw new Exception('WRONG_XML');
            }
        }
        catch (Exception $e) {
            $message = $e->getMessage();
        }
        
        return $message;
    }

}

?>
