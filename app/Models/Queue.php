<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Queue
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class Queue extends Model
{
   /** @var string NOT_RESERVED queue nao reservada */
   const NOT_RESERVED = 0;

   /** @var string RESERVED queue reservada */
   const RESERVED = 1;

   public $table = 'jobs';
}
