$(function () {
    'use strict'

    var ctxColor1 = '#001737';
    var ctxColor2 = '#1ce1ac';

    var url_inscricoes_meses = "/admin/inscricoesmeses";
    var url_inscricoes_ufs = "/admin/inscricoesufs";
 
    $.get(url_inscricoes_ufs, function(data) {
        if(data){
            var response = data;
            OnSuccess_Inscritos_Ufs(response);
        }
    });

    $.get(url_inscricoes_meses, function (data) {
        if (data) {
            var response = data;
            OnSuccess_Inscricoes_Meses(response);
        }
    });

    function OnSuccess_Inscricoes_Meses(response) {
        var mes = [];
        var total = [];
        var color = [];

        var htmlConteudo = "";

        for (var i in response) {
            mes.push(response[i].mes);
            total.push(response[i].total);
            color.push(response[i].color);
            htmlConteudo += "<div class='col-4'>";
            htmlConteudo += "<p class='tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5'>" + response[i].mes + "</p>";
            htmlConteudo += " <div class='d-flex align-items-center'>";
            htmlConteudo += "<div class='wd-10 ht-10 rounded-circle  mg-r-5' style='background-color: " + response[i].color + " !important;'></div>";
            htmlConteudo += " <h5 class='tx-normal tx-rubik mg-b-0'>" + response[i].total + "</h5>";
            htmlConteudo += "</div>";
            htmlConteudo += "</div>";
        }

        var chartdata = {
            labels: mes,
            datasets: [
                {
                    label: 'Inscrições no mês',
                    backgroundColor: color,
                    data: total
                }
            ]
        };
        var ctx2 = document.getElementById('chartBar2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: chartdata,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false,
                    labels: {
                        display: false
                    }
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            beginAtZero: true,
                            fontSize: 10,
                            fontColor: '#182b49'
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#e5e9f2'
                        },
                        barPercentage: 0.6,
                        ticks: {
                            beginAtZero: true,
                            fontSize: 11,
                            fontColor: '#182b49',
                            max: 100
                        }
                    }]
                }
            }
        });

        $(".barChart").html(htmlConteudo);
    }


    var url_situacao_candidatos = "/admin/situacaocandidatos";

    $.get(url_situacao_candidatos, function (data) {
        if (data) {
            var response = data;
            OnSuccess_Situacao(response);
        }
    });

    function OnSuccess_Situacao(response) {
        var status = [];
        var total = [];
        var color = [];

        var htmlConteudo = "";

        for (var i in response) {
            status.push("Situação: " + response[i].status);
            total.push(response[i].total);
            color.push(response[i].color);


            htmlConteudo += "<div class='col-6'>";
            htmlConteudo += "<p class='tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5'>" + response[i].status + "</p>";
            htmlConteudo += " <div class='d-flex align-items-center'>";
            htmlConteudo += "<div class='wd-10 ht-10 rounded-circle  mg-r-5' style='background-color: " + response[i].color + " !important;'></div>";
            htmlConteudo += " <h5 class='tx-normal tx-rubik mg-b-0'>" + response[i].total + "</h5>";
            htmlConteudo += "</div>";
            htmlConteudo += "</div>";
        }


        var chartdata = {
            labels: status,
            datasets: [
                {
                    label: 'Situação x Inscrições',
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

        var ctx = $("#chartPie");
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: chartdata,
            options: optionpie
        });

        console.log(htmlConteudo);
        $(".pieChart").html(htmlConteudo);


    }


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
            htmlConteudo += "<p class='tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5'>" + response[i].curso + "</p>";
            htmlConteudo += " <div class='d-flex align-items-center'>";
            htmlConteudo += "<div class='wd-10 ht-10 rounded-circle  mg-r-5' style='background-color: " + response[i].color + " !important;'></div>";
            htmlConteudo += " <h5 class='tx-normal tx-rubik mg-b-0'>" + response[i].total + "</h5>";
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

    function OnSuccess_Inscritos_Ufs(response) {
       
        var uf      = [];
        var total   = [];
        var color   = [];

        var htmlConteudo = "";

        for (var i in response) {
            uf.push(response[i].uf);
            total.push(response[i].total);
            color.push(response[i].color);
            htmlConteudo += "<div class='col-4'>";
            htmlConteudo += "<p class='tx-10 tx-uppercase tx-medium tx-color-03 tx-spacing-1 tx-nowrap mg-b-5'>" + response[i].uf + "</p>";
            htmlConteudo += " <div class='d-flex align-items-center'>";
            htmlConteudo += "<div class='wd-10 ht-10 rounded-circle  mg-r-5' style='background-color: " + response[i].color + " !important;'></div>";
            htmlConteudo += " <h5 class='tx-normal tx-rubik mg-b-0'>" + response[i].total + "</h5>";
            htmlConteudo += "</div>";
            htmlConteudo += "</div>";
        }

        var chartdata = {
            labels: uf,
            datasets: [
                {
                    label: 'Quantidade',
                    backgroundColor: color,
                    data: total
                }
            ]
        };
        var ctx2 = document.getElementById('chartArea1').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: chartdata,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false,
                    labels: {
                        display: false
                    }
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            beginAtZero: true,
                            fontSize: 10,
                            fontColor: '#182b49'
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#e5e9f2'
                        },
                        barPercentage: 0.6,
                        ticks: {
                            beginAtZero: true,
                            fontSize: 11,
                            fontColor: '#182b49',
                            max: 100
                        }
                    }]
                }
            }
        });
    }


});