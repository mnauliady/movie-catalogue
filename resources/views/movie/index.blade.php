<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @vite('resources/css/app.css')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        /> -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Document</title>
    </head>

    <body class="bg-sky-900">
        <div class="mx-12">
            <div class="text-center">
                <h1 class="pt-12 text-5xl font-bold text-amber-50 uppercase tracking-wider">
                    Movie Catalogue
                </h1>
            </div>
            <div class="text-center">
                <input class="mt-4 placeholder:text-sky-900 placeholder:italic w-80 px-5 py-2 rounded-lg outline-none placeholder:font-semibold placeholder:opacity-70" type="text" placeholder="Search Movie ..." id="search" />
                <p class="pt-1 text-xs md:text-sm -translate-x-24 text-amber-50 italic font-light">* Minimal 3 character</p>
            </div>
            <div class="">
                <div id="main" class="flex flex-wrap pt-12">
                    @foreach ($responseBody->results as $response)
                    <div class="w-full md:w-1/2 lg:w-1/3 p-4 ">
                        <div class="movie-content text-center rounded-lg bg-amber-50">
                            <div class="title text-2xl font-bold pt-4 h-16 ">{{$response->title}}</div>
                            <img class="w-[450px] mx-auto poster rounded-md" src="https://image.tmdb.org/t/p/original/{{$response->poster_path}}" />
                            <div class="release text-2xl font-semibold">{{$response->release_date}}</div>
                            <div class="vote text-2xl font-medium italic">{{$response->vote_average}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="update flex flex-wrap pt-12"></div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                fetch_customer_data();

                function fetch_customer_data(query = "") {
                    $.ajax({
                        url: "{{ route('movie.search') }}",
                        method: "GET",
                        data: { query: query },
                        dataType: "json",
                        success: function (data) {
                            for (let i = 0; i < data.results.length; i++) {
                                $(".update").append(
                                    "<div class='movie-update w-full md:w-1/2 lg:w-1/3 p-4'><div class='movie-update-content text-center rounded-lg bg-amber-50 '><div class='update-title text-2xl font-bold pt-4 h-16'>" +
                                        data.results[i].title +
                                        "</div><img class='w-[450px] mx-auto poster rounded-md' src='https://image.tmdb.org/t/p/original/" +
                                        data.results[i].poster_path +
                                        "' /><div class='update-release text-2xl font-semibold'>" +
                                        data.results[i].release_date +
                                        "</div><div class='update-vote text-2xl font-medium italic'>" +
                                        data.results[i].vote_average +
                                        "</div></div></div>"
                                );
                            }
                        },
                    });
                }

                $(document).on("keyup", "#search", function () {
                    var query = $(this).val();
                    if (query.length >= 3) {
                        $(".update").empty();
                        $("#main").removeClass("flex flex-wrap");
                        $("#main").addClass("hidden");
                        fetch_customer_data(query);
                    } else if (query.length == 0) {
                        $(".update").empty();
                        $("#main").removeClass("hidden");
                        $("#main").addClass("flex flex-wrap");
                    }
                });
            });
        </script>
    </body>
</html>
