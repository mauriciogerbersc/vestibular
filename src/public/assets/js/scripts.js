$(function () {
    'use strict'

    var url = "/admin/inscritoxcurso";

    $.get(url, function (data) {
        if (data) {
            var response = data;
            OnSuccess_(response);
        }
    });

    function OnSuccess_(response) {
        console.log(response);
        var curso = [];
        var total = [];
        var color = [];

        var htmlConteudo = "";

        for (var i in response) {
            curso.push("Curso " + response[i].curso);
            total.push(response[i].total);
            color.push(response[i].color);


            htmlConteudo += "<div class='col-6'>";
            htmlConteudo += "<p class='tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5'>"+response[i].curso+"</p>";
            htmlConteudo += " <div class='d-flex align-items-center'>";
            htmlConteudo += "<div class='wd-10 ht-10 rounded-circle  mg-r-5' style='background-color: "+response[i].color+" !important;'></div>";
            htmlConteudo += " <h5 class='tx-normal tx-rubik mg-b-0'>"+response[i].total+"</h5>";
            htmlConteudo += "</div>";
            htmlConteudo += "</div>";
        }

        var chartdata = {
            labels: curso,
            datasets: [
                {
                    label: 'Cursos x Inscritos',
                    backgroundColor: color,
                    data: total
                }
            ]
        };

        var optionpie = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };

        var ctx = $("#chartDonut");
        var myDonutChart = new Chart(ctx, {
            type: 'doughnut',
            data: chartdata,
            options: optionpie
        });

        console.log(htmlConteudo);
        $(".inscricoesCursos").html(htmlConteudo);
        
       
    }




});