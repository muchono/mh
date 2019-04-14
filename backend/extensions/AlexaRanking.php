<?php
namespace backend\extensions;

/**
 * PHP Class to get a website Alexa Ranking
 *
 * $url='http://domain.com/';
 * $alexa = new AlexaRanking();
 * echo "Rank ".$alexa->getRank($url);
 */
class AlexaRanking
{
    const URL = "http://data.alexa.com/data?cli=10&dat=snbamz&url=";
    /**
     * Get the rank from alexa for the given domain
     * 
     * @param $domain
     * The domain to search on
     */
    public function getRank($domain)
    {
        $data = $this->getContent($domain);
        $rank = 0;
        if (trim($data)) {
            try {
                $xml = new \SimpleXMLElement($data);
                $popularity = $xml->xpath("//POPULARITY");
                if ($popularity) {
                    $rank = (string) $popularity[0]['TEXT'];
                }
            } catch (Exception $ex) {

            }
        }

        return $rank;
    }
    
    public function getContent($domain)
    {
        $url = self::URL . $domain;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }
}