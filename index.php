<!-- HTML STARTS HERE -->
<!DOCTYPE>
<html>

<head>
    <meta charset="utf-8">
    <title>Search Phone</title>
    <link rel="stylesheet" href="css/main.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container-fluid mt-5 w-50 text-center">
        <div class="md-form">
            <i class="fas fa-search prefix float-start mt-2 me-2"></i>
            <input type="text" id="search-form" class="search form-control" style="width:90%;">
        </div>
        <div class="dropdown" style="width: 95%;">
            <div id="search-result" class="dropdown-menu dropdown-primary">
            </div>
        </div>
    </div>

    <div class="res mt-3 border border-primary p-4">
    </div>

    <!-- MDB -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    <script>
        $('#search-result').on('click', '.mobile', function() {
            console.log($(this).text());
            const brand = $(this).data("brand");
            const model = $(this).data("model");
            const img = $(this).data("img");
            const os = $(this).data('os');
            const ram = $(this).data('ram');
            const colors = $(this).data('colors');
            const memory = $(this).data('memory');
            const primary_camera = $(this).data('primary_camera');
            const secondary_camera = $(this).data('secondary_camera');

            $('.res').html(`
                    <center>
                        <img src="${img}" height="150" width="100" class="mb-2">
                    </center>
                    <p><b>Name</b>: ${brand} ${model}</p>
                    <p><b>Company</b>: ${brand}</p>
                    <p><b>RAM</b>: ${ram}</p>
                    <p><b>Memory</b>: ${memory}</p>
                    <p><b>Primary Camera</b>: ${primary_camera}</p>
                    <p><b>Secondary Camera</b>: ${secondary_camera}</p>
                    <p><b>OS</b>: ${os}</p>
                    <p><b>Colors</b>: ${colors}</p>

                `);
            $(".res").show();
        })
        $(document).ready(function() {

            $('html').click(function() {
                $('#search-result').hide();
            });

            $('input.search').on('keydown', function(e) {
                phones = '';

                $.ajax({
                    url: "search.php",
                    method: 'get',
                    dataType: "json",
                    data: {
                        q: $(this).val()
                    },
                    success: function(result) {
                        if (result['status']) {
                            $.each(result["data"], function(key, value) {

                                const brand = value['_source']['brand'];
                                const model = value['_source']['model'];
                                const img_url = value['_source']['img_url'];
                                const os = value['_source']['OS'];
                                const ram = value['_source']['RAM'];
                                const colors = value['_source']['colors'];
                                const memory = value['_source']['internal_memory'];
                                const primary_camera = value['_source']['primary_camera'];
                                const secondary_camera = value['_source']['secondary_camera'];

                                phones +=
                                    `<div style="display:flex;flex-direction:row">
                                <img src="${img_url}" height="55" width="50" class="float-start">
                                <a class="dropdown-item mobile" href="#" 
                                data-brand="${brand}" 
                                data-model="${model}" 
                                data-img="${img_url}"
                                data-os="${os}"
                                data-ram="${ram}"
                                data-colors="${colors}"
                                data-memory="${memory}"
                                data-primary_camera="${primary_camera}"
                                data-secondary_camera="${secondary_camera}"
                                > 
                                    ${brand} ${model} </a>
                                </div>`
                            });
                            $('#search-result').empty().append(phones);

                            if ($('#search-result').html() != "") {
                                $('#search-result').show();
                            }
                        }else{
                            alert(result["message"]);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>