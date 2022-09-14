<?php
    define("MAX_RESULTS", 4);
    
     if (isset($_POST['submit']) )
     {
        $keyword = $_POST['keyword'];
               
        if (empty($keyword))
        {
            $response = array(
                  "type" => "error",
                  "message" => "Debes introducir al menos una palabra."
                );
        } 
    }
         
?>
<!doctype html>
<html>
    <head>
        <title>Busca el video</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <style>

            body {
                font-family: Arial;
                width: 900px;
                padding: 10px;
                background-color: #121212;
            }
            .search-form-container {
                background: #F0F0F0;
                border: #e0dfdf 1px solid;
                padding: 20px;
                border-radius: 2px;
            }
            .input-row {
                margin-bottom: 20px;
            }
            .input-field {
                width: 100%;
                border-radius: 2px;
                padding: 10px;
                border: #e0dfdf 1px solid;
            }
            .btn-submit {
                padding: 10px 20px;
                background: #333;
                border: #1d1d1d 1px solid;
                color: #f0f0f0;
                font-size: 0.9em;
                width: 100px;
                border-radius: 2px;
                cursor:pointer;
            }
            .videos-data-container {
                background: #F0F0F0;
                border: #e0dfdf 1px solid;
                padding: 20px;
                border-radius: 2px;
            }
            
            .response {
                padding: 10px;
                margin-top: 10px;
                border-radius: 2px;
            }

            .error {
                 background: #fdcdcd;
                 border: #ecc0c1 1px solid;
            }

           .success {
                background: #c5f3c3;
                border: #bbe6ba 1px solid;
            }
            .result-heading {
                margin: 20px 0px;
                padding: 20px 10px 5px 0px;
                border-bottom: #e0dfdf 1px solid;
            }
            iframe {
                border: 0px;
            }
            .video-tile {
                display: inline-block;
                margin: 10px 10px 20px 10px;
            }
            
            .videoDiv {
                width: 250px;
                height: 150px;
                display: inline-block;
            }
            .videoTitle {
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }
            
            .videoDesc {
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
            }
            .videoInfo {
                width: 250px;
            }
        </style>
        
    </head>
    <body>
        <h2>Busca el video</h2>
        <div class="search-form-container">
            <form id="keywordForm" method="post" action="">
                <div class="input-row">
                    Busqueda : <input class="input-field" type="search" id="keyword" name="keyword"  placeholder="Ej. Despacito">
                </div>

                <input class="btn-submit"  type="submit" name="submit" value="Buscar">
            </form>
        </div>
        
        <?php if(!empty($response)) { ?>
                <div class="response <?php echo $response["type"]; ?>"> <?php echo $response["message"]; ?> </div>
        <?php }?>
        <?php
            if (isset($_POST['submit']) )
            {
                                         
              if (!empty($keyword))
              {

                if (str_contains($keyword, ' ')) {
                    $nuevo_string = str_replace(' ', '+', $keyword);

                    $keyword = $nuevo_string;
                }

                $apikey = 'AIzaSyBY5YhN6zaeqIgv0QqcBYRJz1VM3W33luE'; 
                $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . $keyword . '&maxResults=' . MAX_RESULTS . '&key=' . $apikey;

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);

                curl_close($ch);
                $data = json_decode($response);
                $value = json_decode(json_encode($data), true);
            ?>

            <div class="result-heading">Escoge el video.</div>
            <div class="videos-data-container" id="SearchResultsDiv">

            <?php
                for ($i = 1; $i < MAX_RESULTS; $i++) {

                    if(str_contains($value['items'][$i]['id']['kind'], 'youtube#channel'))
                        continue;

                    $videoId = $value['items'][$i]['id']['videoId'];
                    $title = $value['items'][$i]['snippet']['title'];
                    $img = 'https://img.youtube.com/vi/'.$videoId.'/0.jpg';
                    
                    ?> 
    
                        <div class="video-tile">
                        <div class="videoInfo">
                        <a href="converter.php?vid_id=<?php echo $videoId; ?>"><img src='<?php echo $img; ?>' width = "150px" ></a>
                        <div class="videoTitle"><b><?php echo $title; ?></b></div>
                        </div>
                        </div>
           <?php 
                    }
                } 
           
            }
            ?> 
            
        </div>
        
     
    </body>
</html>