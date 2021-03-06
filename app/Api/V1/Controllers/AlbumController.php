<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

use App\Album;

use App\User;

use App;

use Helpers;

use Validator;

use Config;

use PDF;

use Dingo\Api\Exception\ValidationHttpException;




class AlbumController extends BaseController
{







    


	public function htmltoPdf(Request $request){





         $input = $request->all();


        $validator = Validator::make($input,[
            'token'         =>   'required',
            'album_name'    =>   'required',
            'baby_name'     =>   'required',
            'url1'          =>   'required',
            'url2'          =>   'required',
            'url3'          =>   'required',
            'url4'          =>   'required',
            'url5'          =>   'required',
            'url6'          =>   'required',
            'url7'          =>   'required',
            'url8'          =>   'required',

            
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $accesstoken=$input['token'];

        $user = User::where('accesstoken','=',$accesstoken)->first();
        $user_id = $user->_id;
        $album_name = $input['album_name'];
        $baby_name  = $input['baby_name'];


        $url1=$input['url1'];
        $url2=$input['url2'];
        $url3=$input['url3'];
        $url4=$input['url4'];
        $url5=$input['url5'];
        $url6=$input['url6'];
        $url7=$input['url7'];
        $url8=$input['url8'];


    $html= "<!DOCTYPE html>
<html lang=\"en\">

<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>專冊樣式一</title>

    <link href=\"bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"css/album1.css\" rel=stylesheet>
 
</head>

<body>
    <div>
        <div class=\"paper cover\">
            <div class=\"topic\">
                <p>
                OurBaby, ourMemory
                </p>
            </div>

            <div class=\"cover-photo\">
                <div class=\"photo-for-cover\" style=\"background-image:url(image/photo-cover.jpg)\"></div>
                <div class=\"title1\">{$baby_name}</div>
                <div class=\"subtitle1\">My Baby</div>
            </div>

            <div class=\"yearly\" style=\"margin-top: 200mm; margin-left: 10mm; font-size: 25px;\">
                2 years old
            </div>

            <div class=\"yearly\" style=\"margin-top: 212mm; margin-left: 25mm; font-size: 37px;\">
                .2016.
            </div>

        </div>

        <div class=\"paper left-page\">
            
            <div class=\"photo-type-big\" style=\"transform: rotate(-3deg); margin-left: 23mm; margin-top: 20mm; z-index: 999;\" >
                <div class=\"photo-type-1\" style=\"background-image:url({$url1})\"></div>
            </div>

            <div class=\"photo-type-big\" style=\"transform: rotate(1deg); margin-left: 20mm; margin-top: 150mm; z-index: 0;\">
                <div class=\"photo-type-1\" style=\"background-image:url({$url2})\"></div>
            </div>

        </div>

        <div class=\"paper right-page\">
            
            <div class=\"photo-type-big\" style=\"transform: rotate(3deg); margin-left: 20mm; margin-top: 30mm; z-index: 999;\">
                <div class=\"photo-type-1\" style=\"background-image:url({$url3})\"></div>
            </div>

            <div class=\"photo-type-small\" style=\"transform: rotate(-1deg); margin-left: 15mm; margin-top: 155mm; z-index: 0;\">
                <div class=\"photo-type-2\" style=\"background-image:url({$url4})\"></div>
            </div>

            <div class=\"dialog-type-1\" style=\"transform: rotate(5deg); margin-left: 103mm; margin-top: 165mm;\">
                <div class=\"commentator-photo\" style=\"background-image:url(image/commentator.jpg)\"></div>
                <div class=\"dialog1\">
                    <p>
                    慈母手中線，遊子身上衣。<br/>
                    臨行密密縫，意恐遲遲歸。<br/>
                    誰言寸草心，報得三春暉。<br/>
                    <br/>
                    寶貝，愛你<br/>
                    永遠愛你<br/>

                    快快睡，我寶貝， 窗外天已黑，小鳥回巢去，太陽也休息，到天亮，出太陽，又是鳥語花香，到天亮，出太陽，又是鳥語花香快睡覺，我寶寶，兩眼要閉好，媽媽看護你，安睡不怕懼，好寶寶，安睡了，我的寶寶睡了，好寶寶，安睡了，我的寶寶睡了，。
                    </p>
                </div>
            </div>

        </div>
        
        <div class=\"paper left-page\">
            <div class=\"photo-type-small\" style=\"transform: rotate(3deg); margin-left: 20mm; margin-top: 40mm; z-index: 0;\">
                <div class=\"photo-type-2\" style=\"background-image:url({$url5})\"></div>
            </div>

            <div class=\"dialog-type-2\" style=\"margin-left: 105mm; margin-top: 40mm; z-index: 999;\">
                <p>My Beauty be Happy</p>
            </div>

            <div class=\"photo-type-small\" style=\"transform: rotate(-4deg); margin-left: 20mm; margin-top: 150mm; z-index: 1;\">
                <div class=\"photo-type-2\" style=\"background-image:url({$url6})\"></div>
            </div>

            <div class=\"photo-type-small\" style=\"transform: rotate(2deg); margin-left: 105mm; margin-top: 135mm; z-index: 0;\">
                <div class=\"photo-type-2\" style=\"background-image:url({$url7})\"></div>
            </div>
        </div>


        <div class=\"paper backcover\">
            <div class=\"backcover-photo\" style=\"margin-left: 80mm; margin-top: 220mm;\">
                <div class=\"photo-for-backcover\" style=\"background-image:url({$url8})\"></div>
            </div>

            <div class=\"backcover-topic\">
                <p>BigWish</p>
            </div>
        </div>
    </div>

</body>

</html>";


    $htmlpath = "tmp/album2/";


    if (!file_exists($htmlpath)) {
    mkdir($htmlpath, 0777, true);
    $uploaddir = $htmlpath;
}
else{
  $uploaddir = $htmlpath;
}



    $uploadfile = $uploaddir .$album_name .".html";

if (file_put_contents($uploadfile, $html) !== false) {
    echo "File created (" . basename($uploadfile) . ")";
} else {
    echo "Cannot create file (" . basename($uploadfile) . ")";
}


 $path = "uploads/{$user_id}/album/";


  if (!file_exists($path)) {
    mkdir($path, 0777, true);
    $uploaddir = $path;
}
else{
  $uploaddir = $path;

}



    $album = new Album;
    $author = User::where('accesstoken','=',$input['token'])->first();
    $album->album_name=$album_name;
    $album->author_name=$author->name;
    $album->author_id=$author->_id;
    $album->pdf_url="http://140.136.155.143/".$uploaddir.$album_name.".pdf";
    $album->save();



    $snappy = App::make('snappy.pdf');
    $snappy->generate($uploadfile,$uploaddir.$album_name.".pdf");


    



    return response()->json($album);


 

}



public function htmltoPdf2(Request $request){





         $input = $request->all();


        $validator = Validator::make($input,[
            'token'         =>   'required',
            'album_name'    =>   'required',
            'baby_name'     =>   'required',
            'url1'          =>   'required',
            'url2'          =>   'required',
            'url3'          =>   'required',
            'url4'          =>   'required',
            'url5'          =>   'required',
            

            
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $accesstoken=$input['token'];

        $user = User::where('accesstoken','=',$accesstoken)->first();
        $user_id = $user->_id;
        $album_name = $input['album_name'];
        $baby_name  = $input['baby_name'];


        $url1=$input['url1'];
        $url2=$input['url2'];
        $url3=$input['url3'];
        $url4=$input['url4'];
        $url5=$input['url5'];
        


    $html= "<!DOCTYPE html>
<html lang=\"en\">

<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>專冊樣式二</title>
    <!-- Bootstrap -->
    <link href=\"bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"css/album2.css\" rel=stylesheet>
    <!-- HTML5 shim and Respond.js 讓 IE8 支援 HTML5 元素與媒體查詢 -->
    <!-- 警告：Respond.js 無法在 file:// 協定下運作 -->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
      <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->
</head>

<body>
    <div>
        <div class=\"paper cover\">
            <div class=\"cover-border\"></div>
            <div class=\"title-container\">
                <div class=\"title1\">{$baby_name}</div>
                <div class=\"subtitle1\">My Baby</div>
            </div>
            <div class=\"cover-photo\" style=\"background-image: url({$url1});\"></div>
            <div class=\"decoration\" style=\"margin-left: 95mm; margin-top: 170mm; width: 92mm;\"></div>

            <div class=\"yearly\" style=\"margin-left: 110mm; margin-top: 171mm\>2016</div>
            <div class=\"yearly\" style=\"margin-left: 152mm; margin-top: 171mm\">3 years old</div>

            <div class=\"decoration\" style=\"margin-left: 107mm; margin-top: 180mm\"></div>
            <div class=\"image-for-cover\"></div>

        </div>

        <div class=\"paper left-page\">        
            <div class=\"photo-type-1\" style=\"margin-left: 10mm; margin-top: 30mm; background-image: url({$url2})\"></div>
            <div class=\"dialog-type-1\" style=\"margin-left: 120mm; margin-top: 250mm\">“ 好可愛噢 !! ”</div>
            <div class=\"commentator\" style=\"margin-left: 155mm; margin-top: 251mm\">—— 某某某 的留言</div>
        </div>

        <div class=\"paper right-page\">
            <div class=\"photo-type-2\" style=\"background-image: url({$url3})\"></div>
            <div class=\"dialog-type-2\" style=\"margin-left: 180mm; margin-top: 100mm\"><p>“ 哇 這張拍得好好 ”</p></div>
            <div class=\"commentator-vertical\" style=\"margin-left: 180mm; margin-top: 150mm\"><p>—— 某某某 的留言</p></div>
        </div>
        
        <div class=\"paper left-page\">
            <div class=\"photo-type-3\" style=\"margin-top: 40mm; background-image: url({$url4})\"></div>
            <div class=\"photo-type-3\" style=\"margin-top: 150mm; background-image: url({$url5})\"></div>
        </div>


        <div class=\"paper backcover\">
            <div class=\"cover-border\" style=\"margin-left: 198mm\"></div>
            <div class=\"image-for-backcover\" style=\"background-image: url(image/animal_back.png)\"></div>
        </div>
    </div>


    <!-- jQuery (Bootstrap 所有外掛均需要使用) -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
    <!-- 依需要參考已編譯外掛版本（如下），或各自獨立的外掛版本 -->
    <script src=\"js/bootstrap.min.js\"></script>
</body>

</html>
";


    $htmlpath = "tmp/album3/";


    if (!file_exists($htmlpath)) {
    mkdir($htmlpath, 0777, true);
    $uploaddir = $htmlpath;
}
else{
  $uploaddir = $htmlpath;
}



    $uploadfile = $uploaddir .$album_name .".html";

if (file_put_contents($uploadfile, $html) !== false) {
    echo "File created (" . basename($uploadfile) . ")";
} else {
    echo "Cannot create file (" . basename($uploadfile) . ")";
}


 $path = "uploads/{$user_id}/album/";


  if (!file_exists($path)) {
    mkdir($path, 0777, true);
    $uploaddir = $path;
}
else{
  $uploaddir = $path;

}



    $album = new Album;
    $author = User::where('accesstoken','=',$input['token'])->first();
    $album->album_name=$album_name;
    $album->author_name=$author->name;
    $album->author_id=$author->_id;
    $album->pdf_url="http://140.136.155.143/".$uploaddir.$album_name.".pdf";
    $album->save();



    $snappy = App::make('snappy.pdf');
    $snappy->generate($uploadfile,$uploaddir.$album_name.".pdf");


    



    return response()->json($album);


 

}



public  function search(Request $request){

          $input = $request -> all();
          $validator = Validator::make($input,[
            'token' => 'required',
            
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $author = User::where('accesstoken','=',$input['token'])->first();
        $author_id = $author->_id;
        $albums =  Album::where('author_id','=',$author_id)->orderBy('created_at','DESC')->get();



        return response()->json($albums);


    }


}