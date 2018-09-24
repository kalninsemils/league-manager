<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>League Manager</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  rel="stylesheet" type="text/css">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                text-align: left;
            }

            .content {
                text-align: center;
                padding-top: 20px;
            }
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            ul {
                padding: 0px;
            }
            li {

                list-style-type: none;
            }
            .m-b-md {
                margin-bottom: 30px;
            }

            .hidden {
                display: none;
            }
            .row {
                width: 100%;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <a id="generate-teams" class="  btn btn-primary" href="/team/generate">Generate Teams</a>
            <div id="teams"><ul></ul></div>
            <a id="generate-league" class="hidden  btn btn-primary" href="/league/generate">Create League</a>
            <div id="league"></div>
            <div class="row">
                <div class="col-md-6" id="division_0">
                    <h3 class="title"></h3>
                    <ul>
                    </ul>
                    <a class="hidden generate-score  btn btn-primary" href="#">Generate Score</a>
                </div>
                <div class="col-md-6" id="division_1">
                    <h3 class="title"></h3>
                    <ul>
                    </ul>
                    <a class="hidden generate-score  btn btn-primary" href="#">Generate Score</a>
                </div>
            </div>
            <div id="finals">
                <a id="generate-finals" class="hidden btn btn-primary" href="#">Generate Finals</a>
            </div>
        </div>
        <script>
            $('#generate-teams').on('click', function(e) {
                e.preventDefault();
                $.get($(this).attr('href')).done(function(teams) {
                    $('#teams').prepend('<h2>New Teams added to database:</h2>');
                    $.each(teams, function(key, item) {

                        $('#teams ul').append('<li>' + item.name + '</li>');
                    });
                    $('#generate-teams').addClass('hidden');
                    $('#generate-league').removeClass('hidden');

                });

            });
            $('#generate-league').on('click', function(e) {
                e.preventDefault();
                $.get($(this).attr('href')).done(function(league) {
                    $('#teams').addClass('hidden');
                    $('#league').append('<h2>' + league.name + '</h2>');
                    $('#generate-finals').attr('data-id', league.id);
                    $.post('/division/generate', {league_id: league.id}).done(function(divisions) {
                        $.each(divisions, function(key, division) {
                            $('#generate-league').addClass('hidden');
                            $('#division_'+key+' a').attr('data-id', division.id).removeClass('hidden');
                            $('#division_'+key+' .title').text(division.name);
                            $.each(division.teams, function(key2, item) {

                                $('#division_' + key + ' ul').append('<li>'+item.name+'</li');
                            });
                        });
                    })
                })
            });

            $('.generate-score').on('click', function(e) {
                e.preventDefault();
                var that = this;
                $.post('/score/division', {division_id: $(this).data('id')}).done(function(score) {
                    $(that).addClass('hidden');
                    if ($('.generate-score:not(.hidden)').length < 1) {
                        $('#generate-finals').removeClass('hidden');
                    }

                    $(that).parents('.col-md-6').find('ul').html('');
                    $.each(score, function(key, item) {

                        $(that).parents('.col-md-6').find('ul').append('<li>'+item.winner.name + ' 1 : 0 ' + item.loser.name+'</li');
                    });
                });
            });

            $('#generate-finals').on('click', function(e) {
                e.preventDefault();
                $.post('/score/finals', {league_id: $(this).data('id')}).done(function(score) {
                    $('#generate-finals').addClass('hidden');
                    var ul = $('#generate-finals').parents('div').find('ul');
                    $.each(score, function(key, items_groups) {
                        $('#finals').append('<h3>'+key + ' Round</h3>')
                        $('#finals').append('<ul class="ul-'+key+'"></ul>');

                        $.each(items_groups, function(key2, items) {


                            $.each(items, function(key3, item) {
                                $('.ul-' + key).append('<li>'+ item.winner.name+ ' 1:0 ' + item.loser.name + '</li');
                            });
                            $('.ul-' + key).append('<li>&nbsp;</li');
                        });
                    });
                });
            });
        </script>
    </body>
</html>
