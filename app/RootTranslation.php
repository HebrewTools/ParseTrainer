<?php
/**
 * Created by PhpStorm.
 * User: camil
 * Date: 1/4/16
 * Time: 4:06 PM
 */
namespace HebrewParseTrainer;

use Illuminate\Database\Eloquent\Model;

class RootTranslation extends Model {

    protected $table = 'root_translations';

    protected $fillable = ['root', 'translation'];

}