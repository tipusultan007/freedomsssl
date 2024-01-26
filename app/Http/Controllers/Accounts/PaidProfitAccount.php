<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaidProfitAccount extends Controller
{
    public static function create($data)
    {
        switch ($data['profit_type'])
        {
            case "daily":
                $paid = Account::find(38);
                $paid->balance += $data['profit'];
                $paid->save();
                $unpaid = Account::find(43);
                $unpaid->balance -= $data['profit'];
                $unpaid->save();
                $transaction = Transaction::create([
                    'account_id' => 38,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['profit'],
                    'user_id' => $data['created_by'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            case "dps":
                $account = Account::find(39);
                $account->balance += $data['profit'];
                $account->save();
                $transaction = Transaction::create([
                    'account_id' => 39,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['profit'],
                    'user_id' => $data['collector_id'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            case "special":
                $account = Account::find(40);
                $account->balance += $data['interest'];
                $account->save();
                $transaction = Transaction::create([
                    'account_id' => 40,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['interest'],
                    'user_id' => $data['collector_id'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            case "fdr":
                $account = Account::find(41);
                $account->balance += $data['profit'];
                $account->save();
                $unpaid = Account::find(42);
                $unpaid->balance -= $data['profit'];
                $unpaid->save();
                $transaction = Transaction::create([
                    'account_id' => 41,
                    'description' => $data['description']??'',
                    'trx_id' => $data['trx_id'],
                    'date' => $data['date'],
                    'amount' => $data['profit'],
                    'user_id' => $data['created_by'],
                    'account_no' => $data['account_no'],
                    'name' => $data['name'],
                    'type' => $data['trx_type']
                ]);
                break;
            default:

        }


        switch ($transaction->type)
        {
            case "cash":
                $account = Account::find(5);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "bank":
                $account = Account::find(3);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "bkash":
                $account = Account::find(4);
                $account->balance -= $transaction->amount;
                $account->save();
                break;
            case "nagad":
                $account = Account::find{
  "pageCacheStats" : {
    "cachedChannelsStatistics" : {
      "hit" : 284,
      "miss" : 4,
      "load" : 300,
      "capacity" : 400
    },
    "uncachedFileAccess" : 440,
    "maxRegisteredFiles" : 1336,
    "maxCacheSizeInBytes" : 532742144,
    "totalCachedSizeInBytes" : 523386880,
    "pageHits" : 113,
    "pageFastCacheHits" : 160710,
    "pageLoadsAboveSizeThreshold" : 278,
    "regularPageLoads" : 643,
    "disposedBuffers" : 304,
    "totalPageDisposalUs" : 1003,
    "totalPageLoadUs" : 919730,
    "totalPagesLoaded" : 921,
    "capacityInBytes" : 524288000
  },
  "vfsStorageStats" : {
    "statsPerEnumerator" : {
      "contentHashes.dat" : {
        "collisions" : 0,
        "values" : 15827,
        "dataFileSizeInBytes" : 316540,
        "storageSizeInBytes" : 96,
        "btreeStatistics" : {
          "pages" : 9,
          "elements" : 15827,
          "height" : 2,
          "moves" : 13,
          "leafPages" : 8,
          "maxSearchStepsInRequest" : 55,
          "searchRequests" : 60237,
          "searchSteps" : 88338,
          "pageCapacity" : 32768,
          "sizeInBytes" : 294912
        }
      },
      "names.dat" : {
        "collisions" : 8,
        "values" : 44482,
        "dataFileSizeInBytes" : 1071969,
        "storageSizeInBytes" : 192,
        "btreeStatistics" : {
          "pages" : 17,
          "elements" : 44477,
          "height" : 2,
          "moves" : 46,
          "leafPages" : 16,
          "maxSearchStepsInRequest" : 77,
          "searchRequests" : 1219806,
          "searchSteps" : 698605,
          "pageCapacity" : 32768,
          "sizeInBytes" : 557056
        }
      }
    }
  },
  "indexStorageStats" : {
    "indexStoragesStats" : {
      "CompassFunctionsIndex" : {
        "statsPerPhm" : {
          "CompassFunctionsIndex.storage" : {
            "persistentEnumeratorStatistics" : {
              "collisions" : 0,
              "values" : 0,
              "dataFileSizeInBytes" : 0,
              "storageSizeInBytes" : 96,
              "btreeStatistics" : {
                "pages" : 0,
                "elements" : 0,
                "height" : 0,
                "moves" : 0,
                "leafPages" : 1,
                "maxSearchStepsInRequest" : 0,
                "searchRequests" : 0,
                "searchSteps" : 0,
                "pageCapacity" : 32768,
                "sizeInBytes" : 0
              }
            },
            "valueStorageSizeInBytes" : 0
          },
          "CompassFunctionsIndex_inputs" : {
            "persistentEnumeratorStatistics" : {
              "collisions" : 0,
              "values" : 0,
              "dataFileSizeInBytes" : -1,
              "storageSizeInBytes" : 96,
              "btreeStatistics" : {
                "pages" : 0,
                "elements" : 0,
                "height" : 0,
                "moves" : 0,
                "leafPages" : 1,
                "maxSearchStepsInRequest" : 0,
                "searchRequests" : 0,
                "searchSteps" : 0,
                "pageCapacity" : 32768,
                "sizeInBytes" : 0
              }
            },
            "valueStorageSizeInBytes" : 0
          }
        }
      },
      "CssIndex" : {
        "statsPerPhm" : {
          "CssIndex.storage" : {
            "persistentEnumeratorStatistics" : {
              "collisions" : 16,
              "values" : 5828,
              "dataFileSizeInBytes" : 50068,
              "storageSizeInBytes" : 50936,
              "btreeStatistics" : {
                "pages" : 3,
                "elements" : 5820,
                "height" : 2,
                "moves" : 0,
                "leafPages" : 2,
                "maxSearchStepsInRequest" : 54,
                "searchRequests" : 101109,
                "searchSteps" : 82958,
                "pageCapacity" : 32768,
                "sizeInBytes" : 98304
              }
            },
            "valueStorageSizeInBytes" : 1409012
          },
          "CssIndex_inputs" : {
            "persistentEnumeratorStatistics" : {
              "collisions" : 0,
              "values" : 0,
              "dataFileSizeInBytes" : -1,
              "storageSizeInBytes" : 96,
              "btreeStatistics" : {
                "pages" : 1,
                "elements" : 2370,
                "height" : 1,
                "moves" : 0,
                "leafPages" : 1,
                "maxSearchStepsInRequest" : 46,
                "searchRequests" : 68363,
                "searchSteps" : 63391,
                "pageCapacity" : 32768,
                "sizeInBytes" : 32768
              }
            },
            "valueStorageSizeInBytes" : 1245180
          }
        }
      },
      "DomFileIndex" : {
        "statsPerPhm" : {
          "DomFileIndex.storage" : {
            "persistentEnumeratorStatistics" : {
              "collisions" : 0,
              "values" : 20,
              "dataFileSizeInBytes" : 525,
              "storageSizeInBytes" : 288,
              "btreeStatistics" : {
                "pages" : 1,
                "elements" : 20,
                "height" : 1,
                "moves" : 0,
                "leafPages" : 1,
                "maxSearchStepsInRequest" : 0,
                "searchRequests" : 152,
                "searchSteps" : 0,
                "pageCapacity" : 32768,
                "sizeInBytes" : 32768
              }
            },
            "valueStorageSizeInBytes" : 1255
          },
          "DomFileIndex_inputs" : {
            "persistentEnumeratorStatistics" : {
              "collisions" : 0,
              "values" : 0,
              "dataFileSizeInBytes" : -1,
              "storageSizeInBytes" : 96,
              "btreeStatistics" : {
                "pages" : 1,
                "elements" : 172,
                "height" : 1,
                "moves" : 0,
                "leafPages" : 1,
                "maxSearchStepsInRequest" : 1,
                "searchRequests" : 518,
                "searchSteps" : 6,
                "pageCapacity" : 32768,
                "sizeInBytes" : 32768
              }
   