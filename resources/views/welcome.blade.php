<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduBuddy - Teman Setia Waktu Kamu Belajar</title>
    <link rel="stylesheet" href="#navbar-styles">
    <link rel="stylesheet" href="#carousel-styles">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


</head>

<body>
    <!-- Navbar -->
@include('layout.template')

    <!-- Enhanced Carousel Section -->
@include('layout.carousel')

    <script src="#carousel-scripts"></script>
    <script src="#main-scripts"></script>


    <!-- Footer Section -->
    @extends('layout.footer')

</body>
