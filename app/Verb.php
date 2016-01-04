<?php
/**
 * Created by PhpStorm.
 * User: camil
 * Date: 1/4/16
 * Time: 4:06 PM
 */
namespace HebrewParseTrainer;

use Illuminate\Database\Eloquent\Model;

class Verb extends Model {

    protected $table = 'verbs';

    protected $fillable = ['verb', 'root', 'stem', 'tense', 'person', 'gender', 'number'];

}