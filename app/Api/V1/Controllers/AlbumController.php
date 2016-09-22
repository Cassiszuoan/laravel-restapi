<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

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
            'user_id'       =>   'required', 
            'album_name'     =>   'required',
            
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $user_id = $input['user_id'];
        $album_name = $input['album_name'];


        $url1="";
        $url2="";
        $url3="";
        $url4="";
        $url5="";
        $url6="";
        $url7="";
        $url8="";


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
                <div class=\"title1\">寶貝名字</div>
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
                <div class=\"photo-type-1\" style=\"background-image:url({$url1}})\"></div>
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


$path = "uploads/{$user_id}/album/";

if (!file_exists($path)) {
    mkdir($path, 0777, true);
    $uploaddir = $path;
}
else{
  $uploaddir = $path;
}

    $uploadfile = $uploaddir .$album_name .".html";

if (file_put_contents($uploadfile, $html) !== false) {
    echo "File created (" . basename($uploadfile) . ")";
} else {
    echo "Cannot create file (" . basename($uploadfile) . ")";
}



    $snappy = App::make('snappy.pdf');
    $snappy->generate("http://140.136.155.143/". $uploadfile,"/tmp/{$album_name}.pdf");
    // $snappy->generateFromHtml('<h1>Bill</h1><p>You owe me money, dude.</p>', '/tmp/bill-123.pdf');
    
    


 

}


}