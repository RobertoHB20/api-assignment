<?php
namespace App\Services;

use App\Repositories\RequestApiLogRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FetchDataService {

    protected $url;
    protected $pages_repository;
    protected $guzzle_client;

    public function __construct(RequestApiLogRepository $repository){
        $this->url = env('API_URL', 'https://reqres.in/api');
        $this->pages_repository = $repository;
        $this->guzzle_client = new Client();
    }


    /**
     * Method to get information of users in an external API, sending a get request to fetch that information
     * @return array with users information, if it fails it'll still return an empty array
     */
    public function fetchData(){
        $resource = '/users';
        $page = '?page=';
        $today = date('d-m-Y G:i:s');
        try{
            $last_page = $this->pages_repository->getLastPage();
            $next_page = $last_page ? $last_page['page'] + 1 : 1;

            $data_fetched = $this->guzzle_client->get( $this->url.$resource.$page.$next_page );

            $this->pages_repository->savePage($next_page);

            return json_decode( $data_fetched->getBody(), true );

        }catch(\PDOException $e){
            Log::error("There was an error fetching information from db on date ".$today);
            Log::error("Error: ".$e->getMessage());
            return ['data' => []];

        }catch(\Exception $e){
            Log::error("There was an error on date ".$today." in fetch_data_service");
            Log::error("Error: ".$e->getMessage());
            return ['data' => []];
        }
    }



}
