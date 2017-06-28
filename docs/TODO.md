# 26/06/2017

## Single image from social networks:

* The case of [the expedition of the local skating comite to the marathon of Dijon](http://rollersports93.fr/semi-et-marathon-de-dijon/) shows I notices that I can use a Google Photo URL (Wordpress Kernel) as source for the media
  * in the case the album has been shared through a link!
  * All features of the js libraries are not available !
* I want to test it with public pictures of FaceBook pages like thoses of the [In line skating Montreuil's Derby Facebook page](https://www.facebook.com/RSMontreuilDerby/)

## Galleries from remote storage

* How could I get the image from Google Drive as Galleries


* The images in a Google Photo album are available as :
> https://lh3.googleusercontent.com/jtpShtT9VbXmJoiAmUhrHZpcAxdxiOaJj8DcLUCf_jqbXGEba8ExE0zICqYXW8j6vN98ORAKLIko0Mi_vOtEcLx9ZJ0uabA3CJna8Zm3AG5EdsLUye0Yhqj0CiEab_KqykGRYUk=s903-no

* Anyway the pattern has to do with googleusercontent.com !!!!
* We find them back when dealing with the page content !!!


``` html
["AF1QipOZn2vfRFqJWnXWhb1p5WzaO1Sd","110479333668214642793","Yann Burgraf","https://lh3.googleusercontent.com/9sI1bkmDW1AmtO3PbCEXxY2hJPizgijemA5anVFqwYPL_4kfakj09NgdQPecyUGMuviSne_XLzug4xyg5SRzim8UKG6jWE9aP6IpEA",null,["AF1QipOZn2vfRFqJWnXWhb1p5WzaO1Sd","110479333668214642793"]
,null,null,null,null,null,["Yann Burgraf",1,"male","Yann"]
,["https://lh3.googleusercontent.com/a/AHuHMvcobZ4hrJaYnLkEALa_0Q1cZ3ahYEt4pmWpMss"]
,null,null,null,null,[2]
]

<div class="rtIMgb fCPuz" jsname="NwW5ce" jscontroller="Shr6vb" style="width: 337px; height: 338px; transition: none 0s ease 0s ; transform: translate3d(0px, 0px, 0px);" jslog="6959; track:click; 8:AF1QipNpBpn54e4uzNqTV5UhDkhtecOznBMPih1GHWSG"><a class="p137Zd" tabindex="0" jsaction="click:eQuaEb;focus:AHmuwe; blur:O22p3e;" style="" aria-label="Photo - Square - Jun 11, 2017, 7:53:09 AM" href="./share/AF1QipNmxgf36XzbFOd7wRwntPaxfH14ue8nt62xx98fe8RRvIE2dHsObwxMwb6nGs60Cw/photo/AF1QipNpBpn54e4uzNqTV5UhDkhtecOznBMPih1GHWSG?key=ZFhBTGpVM045WWJ3T2ZMTWMxQW82TkgxdkxhUVZ3"><div class="RY3tic" style="opacity: 1; background-image: url(&quot;https://lh3.googleusercontent.com/jtpShtT9VbXmJoiAmUhrHZpcAxdxiOaJj8DcLUCf_jqbXGEba8ExE0zICqYXW8j6vN98ORAKLIko0Mi_vOtEcLx9ZJ0uabA3CJna8Zm3AG5EdsLUye0Yhqj0CiEab_KqykGRYUk=w337-h338-no&quot;), url(&quot;https://lh3.googleusercontent.com/jtpShtT9VbXmJoiAmUhrHZpcAxdxiOaJj8DcLUCf_jqbXGEba8ExE0zICqYXW8j6vN98ORAKLIko0Mi_vOtEcLx9ZJ0uabA3CJna8Zm3AG5EdsLUye0Yhqj0CiEab_KqykGRYUk=s357-no&quot;);" data-latest-bg="https://lh3.googleusercontent.com/jtpShtT9VbXmJoiAmUhrHZpcAxdxiOaJj8DcLUCf_jqbXGEba8ExE0zICqYXW8j6vN98ORAKLIko0Mi_vOtEcLx9ZJ0uabA3CJna8Zm3AG5EdsLUye0Yhqj0CiEab_KqykGRYUk=w337-h338-no"><div class="eGiHwc" aria-hidden="true"></div><div class="KYCEmd" aria-hidden="true"></div></div></a><div class="RmSd1b" aria-hidden="true"></div><div class="Tee6gf"></div><div class="I6u9xf" jsaction="click:nm7eWc;OhrpU:s7Dew;dnxDue:USNIde;"></div><div class="GzIbP"><div class="P8pGvd"><svg width="24px" height="24px" class="JUQOtc ZlFhfc" viewBox="0 0 24 24"><path d="M12,2C6.5,2,2,6.5,2,12s4.5,10,10,10c5.5,0,10-4.5,10-10S17.5,2,12,2z M10,16.5v-9l6,4.5L10,16.5z"></path></svg><div class="KhS5De"></div><svg width="24px" height="24px" class="JUQOtc U7j2r" viewBox="0 0 24 24"><path d="M19,9l1.2-2.8L23,5l-2.8-1.2L19,1l-1.2,2.8L15,5l2.8,1.2L19,9z M11.5,9.5L9,4L6.5,9.5L1,12l5.5,2.5L9,20l2.5-5.5L17,12 L11.5,9.5z M19,15l-1.2,2.7L15,19l2.8,1.2L19,23l1.2-2.8L23,19l-2.8-1.2L19,15z"></path></svg><svg width="24px" height="24px" class="JUQOtc W4f4Cd" viewBox="0 0 24 24"><path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4h-2l2 4h-3l-2-4h-1c-1.1 0-1.99.9-1.99 2l-.01 12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-14h-4z"></path></svg></div><div class="bmpxFe"></div></div><div class="qjYJaf" jsaction="click:lSY7nd;" tabindex="0" role="button" title="Remove" aria-label="Remove"><svg width="24px" height="24px" class="JUQOtc" viewBox="-1987 1989 24 24"><radialGradient id="a" cx="-12127.5605" cy="1079.6665" r=".066" gradientTransform="translate(2019285.5 -177942.453) scale(166.6667)" gradientUnits="userSpaceOnUse"><stop offset=".8316" stop-color="#010101"></stop><stop offset="1" stop-color="#010101" stop-opacity="0"></stop></radialGradient><circle opacity=".26" fill="url(#a)" cx="-1975" cy="2002" r="11"></circle><circle opacity=".12" cx="-1975" cy="2001" r="11"></circle><path fill="none" d="M-1987 1989h24v24h-24z"></path><circle fill="#757575" cx="-1975" cy="2001.2" r="8.3"></circle><path fill="#FFF" d="M-1975 1991c-5.5 0-10 4.5-10 10s4.5 10 10 10 10-4.5 10-10-4.5-10-10-10zm5 13.6l-1.4 1.4-3.6-3.6-3.6 3.6-1.4-1.4 3.6-3.6-3.6-3.6 1.4-1.4 3.6 3.6 3.6-3.6 1.4 1.4-3.6 3.6 3.6 3.6z"></path></svg></div></div>

https://photos.google.com/share/AF1QipNmxgf36XzbFOd7wRwntPaxfH14ue8nt62xx98fe8RRvIE2dHsObwxMwb6nGs60Cw/photo/AF1QipNpBpn54e4uzNqTV5UhDkhtecOznBMPih1GHWSG?key=ZFhBTGpVM045WWJ3T2ZMTWMxQW82TkgxdkxhUVZ3

<img jsname="uLHQEd" class="SzDcob" src="https://lh3.googleusercontent.com/jtpShtT9VbXmJoiAmUhrHZpcAxdxiOaJj8DcLUCf_jqbXGEba8ExE0zICqYXW8j6vN98ORAKLIko0Mi_vOtEcLx9ZJ0uabA3CJna8Zm3AG5EdsLUye0Yhqj0CiEab_KqykGRYUk=s903-no" style="transform: translate3d(0px, 0px, 0px) rotate(0deg);" aria-label="Photo - Square - Jun 11, 2017, 7:53:09 AM" width="903" height="903">
s pour size !!!! Quand je demande à FF il me dit que la boîte fait 903x903 !!!!

https://lh3.googleusercontent.com/jtpShtT9VbXmJoiAmUhrHZpcAxdxiOaJj8DcLUCf_jqbXGEba8ExE0zICqYXW8j6vN98ORAKLIko0Mi_vOtEcLx9ZJ0uabA3CJna8Zm3AG5EdsLUye0Yhqj0CiEab_KqykGRYUk=w337-h338-no
w pour width!


jpmena@jpmena-P34:~$ curl https://photos.google.com/share/AF1QipNmxgf36XzbFOd7wRwntPaxfH14ue8nt62xx98fe8RRvIE2dHsObwxMwb6nGs60Cw?key=ZFhBTGpVM045WWJ3T2ZMTWMxQW82TkgxdkxhUVZ3 -o ~/CONSULTANT/googlealbum.html
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100 1069k    0 1069k    0     0   179k      0 --:--:--  0:00:05 --:--:--  219k

```

* When I ask how to get the images from a particular user [I get the new way of doing it](https://stackoverflow.com/questions/9128700/getting-google-profile-picture-url-with-user-id)
  * My question to Google was _what are the parameters to lh3.googleusercontent.com_

* I created the _/home/jpmena/CDRS/wordpress/wp-content/plugins/wp-rsm_galleries/tests/photos.json_ file to store
  * the part of the page containing the useful images datas from [the Dijon Marathon on Google Photos (many contributors)](/home/jpmena/CDRS/wordpress/wp-content/plugins/wp-rsm_galleries/tests/photos.json)

* Find a plugin to get the generated content ???
