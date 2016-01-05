<!DOCTYPE html>
<!--
HebrewParseTrainer - practice Hebrew verbs
Copyright (C) 2015  Camil Staps <info@camilstaps.nl>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 -->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>HebrewParseTrainer</title>
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="public/css/hebrewparsetrainer.css">
    </head>
    <body role="application">
        <div class="container" role="main">
            <div class="page-header">
                <h1>HebrewParseTrainer</h1>
            </div>

            <div class="row">
                <div class="col-md-2 col-sm-4">
                    <form id="hebrewparsetrainer-settings">
                        <div class="form-group">
                            <h3>Stems</h3>
                            <?php foreach (\HebrewParseTrainer\Stem::all() as $stem){ $stem = $stem->name; ?>
                                <div class="checkbox">
                                    <label><input class="reload-verb" type="checkbox" name="stem" value="<?=$stem?>" checked="checked"/> <?=$stem?></label>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <h3>Tenses</h3>
                            <?php foreach (\HebrewParseTrainer\Tense::all() as $tense){ $tense = $tense->name; ?>
                                <div class="checkbox">
                                    <label><input class="reload-verb" type="checkbox" name="tense" value="<?=$tense?>" checked="checked"/> <?=$tense?></label>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <h3>Roots</h3>
                            <?php foreach (\HebrewParseTrainer\Root::all() as $root){ $root = $root->root; ?>
                                <div class="checkbox">
                                    <label class="hebrew"><input class="reload-verb" type="checkbox" name="root" value="<?=$root?>" checked="checked"/> <?=$root?></label>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <h3>Settings</h3>
                            <div class="checkbox">
                                <label><input type="checkbox" id="settings-audio" checked="checked"/> Audio</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-10 col-sm-8" id="trainer-input-container"">
                    <p class="bg-danger" id="trainer-404">There are no verbs matching the criteria in our database.</p>
                    <p class="lead"><span class="hebrew hebrew-large" id="trainer-verb"></span><span id="trainer-answer"></span></p>
                </div>
            </div>
        </div>

        <script src="vendor/components/jquery/jquery.min.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="public/js/hebrewparsetrainer.js"></script>
    </body>
</html>