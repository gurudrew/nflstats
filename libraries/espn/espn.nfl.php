<?php
    require_once realpath(dirname(__FILE__) .'/../') . '/CURLRequest.php';
    define('ESPN_NFL_BASEURL', 'http://api.espn.com/v1/sports/football/nfl/');
    class ESPNNFL {
        public function __construct($apiKey) {
            $this->apiKey = $apiKey;
        }
        function getPlayers($page=false) {
            $request = 'athletes';
            $result = $this->request($request);
            for($i=$result['count'];$i<)
                $request = 'athletes?offset=' . $offset;
                $response = $this->request($request);
                if($response) {
                    $count = $response['count'];
                    $total = $response['total'];
                    $offset += $count;
                    foreach($response['data'] as $player) {
                        $result[] = $player;
                    }
                } else {
                    $offset = $total;
                }
            }
            print_r($result);
            return $result;
        }
        private function request($action, $post=false) {
            $concat = '?';
            if(stristr($action,'?')) $concat = '&';
            $url = ESPN_NFL_BASEURL . $action . $concat . 'apikey=' . $this->apiKey;
            $curl = new CURLRequest($url);
            if($post) { $curl->setPostData($post); }
            $result = $curl->execute();
            $curl->close();
            try { $result = $this->_filterResult(json_decode($result,true)); } catch(Exception $e) {}
            return $result;
        }
        private function _filterResult($result) {
            $newResult = array(
                'offset' => $result['resultsOffset'],
                'count' => $result['resultsLimit'],
                'total' => $result['resultsCount'],
                'timestamp' => $result['timestamp'],
                'status' => $result['status']
            );
            if(isset($result['sports'][0]['leagues'][0])) {
                $newResult['data'] = $result['sports'][0]['leagues'][0]['athletes'];
            }
            return $newResult;
        }
    }
?>