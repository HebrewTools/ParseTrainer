<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>HebrewParseTrainer</title>
        <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/public/css/hebrewparsetrainer.css">
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
                <div class="col-md-10 col-sm-8">
                    <p class="bg-danger" id="trainer-404">There are no verbs matching the criteria in our database.</p>
                    <p class="lead"><span class="hebrew hebrew-large" id="trainer-verb"></span><span id="trainer-answer"></span></p>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="trainer-input">Parse:</label>
                                <input type="text" class="form-control" id="trainer-input" placeholder="Q pf 3 m s"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="trainer-parsed">Interpreted as:</label>
                                <input type="text" class="form-control" id="trainer-parsed" readonly="readonly"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/vendor/components/jquery/jquery.min.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/public/js/hebrewparsetrainer.js"></script>
    </body>
</html>