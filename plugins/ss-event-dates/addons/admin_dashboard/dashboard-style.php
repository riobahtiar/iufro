<?php 
// Dashboard Style 
?>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<style>
    * {
    box-sizing: border-box;
}

.container-iuf {
    font-family: 'Lato', sans-serif;
    margin: 0 auto;
    width: 100%;
    position: relative;
    color: #333;
    padding: 15px 0;
    overflow: hidden;
}

h1,
h2,
h3,
h4,
p {
    margin: 15px 0;
}


/*Counter */

.counter-iuf {
    margin: 0 -5px;
    overflow: hidden;
}

.counter-item-iuf {
    width: 16.6667%;
    float: left;
    text-align: center;
    padding: 5px;
    color: #fff;
    margin-bottom: 15px;
}

.counter-item-iuf h1,
.counter-item-iuf p {
    margin: 0;
}

.counter-item-iuf h1 {
    padding: 30px 0 0 !important;
    font-size: 60px;
    color: white;
    display: inline-block;

}

.counter-item-iuf p {
    padding: 15px 0 !important;
    display: block;
}

.registered-iuf> div {
    background-color: #f17d4a;
}

.attended-iuf> div {
    background-color: #ffb500;
}

.paid-iuf> div {
    background-color: #78b732;
}

.participant-iuf> div {
    background-color: #1eadd9;
}

.auth-iuf> div {
    background-color: #dc5a7c;
}

.unpaid-iuf> div {
    background-color: #78808b;
}


/*Add on facilities */

.info-iuf h2 {
    margin-bottom: 0;
}

.mid-trip-iuf,
.post-trip-iuf,
.place-iuf,
.numb-iuf {
    width: 50%;
    float: left;
}

.trip-iuf {
    overflow: hidden;
    margin: 0 -5px;
}

.mid-trip-iuf,
.post-trip-iuf {
    padding: 5px;
}

.trip-item {
    overflow: hidden;
    margin-bottom: 5px;
    color: #fff;
}

.place-iuf {
    padding-left: 15px;
    background-color: #1eadd9;
}

.numb-iuf {
    text-align: center;
    background-color: #1b95bb;
}


/* Dinner */

.dinner-iuf,
.dinner-numb-iuf {
    width: 50%;
    float: left;
    color: #fff;
}

.dinner-wrap-iuf,
.dinner-iuf-item {
    width: 100%;
    float: left;
}

.dinner-wrap-iuf {
    margin-bottom: 15px;
    margin-top: 15px;
}

.dinner-numb-iuf {
    background-color: #649a29;
    text-align: center;
}

.dinner-iuf {
    background-color: #78b732;
    padding-left: 15px;
}


/* Content Iufro */

.content-wrap-iuf {
    width: 100%;
    float: left;
    border: 1px solid #ccc;
    padding: 5px 15px;
    margin-bottom: 10px;
}

.content-wrap-iuf> h3 {
    float: left;
    display: inline-block;
}

.btn-admin-iuf {
    padding: 7px 30px;
    display: inline-block;
    float: right;
    margin: 8px 0;
    text-decoration: none;
    color: #fff;
}

.btn-black-iuf {
    background-color: #4d5361;
}

.btn-grey-iuf {
    background-color: #949fb3;
}


/*Media  Queries  */

@media (max-width: 767px) {
    .counter-item-iuf {
        width: 100%;
        margin-bottom: 5px;
    }
    .mid-trip-iuf,
    .post-trip-iuf {
        width: 100%;
    }
}
</style>

<?php
    // End Style
?>