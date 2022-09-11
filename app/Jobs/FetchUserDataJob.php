<?php

namespace App\Jobs;

use App\Repositories\UsersRepository;
use App\Services\FetchDataService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;

/**
 * Job to fetch user's information to an external API and save information
 * into users table
 *
 * @see App\Services\FetchDataService
 * @see App\Repositories\UsersRepository
 */
class FetchUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FetchDataService $service, UsersRepository $usersRepository)
    {
        //Fetching user information from external service
        DB::beginTransaction();
        $users = $service->fetchData();
        try{
            foreach($users['data'] as $user){
                $usersRepository->createUser($user);
            }
            DB::commit();
        }catch(PDOException $e){
            DB::rollBack();
            Log::error("There was an error on savin data in db");
            Log::error("Error message: ".$e->getMessage());

        }catch(Exception $e){
            DB::rollBack();
            Log::error("There was an error on Job");
            Log::error("Error message: ".$e->getMessage());
        }
    }
}
