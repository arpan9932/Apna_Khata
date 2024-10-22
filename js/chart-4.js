$(document).ready(function() {
    // Initialize a variable to hold the chart instance
    let chartInstance;

    function loadfirstmonth() {
        if ($('.dynamicSelect').length) {
            var selectedValue = $('.dynamicSelect option:first').val(); 
            console.log("Selected Value: " + selectedValue);

            $.ajax({
                url: 'content/_handalanalysis.php',
                type: 'POST',
                data: { value: selectedValue },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        const categories = response.data.map(item => item.category);
                        const totalSpending = response.data.map(item => parseFloat(item.total_spending));
                        updateChart(categories, totalSpending);
                    } else {
                        console.error('Error: ', response.message);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    }

    function loadSelectOptions() {
        $.ajax({
            url: 'content/_handleMonth.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                const select = $("#dynamicSelect");
                select.empty();
                if (response.status === 'success') {
                    response.options.forEach(function(option) {
                        select.append(new Option(option.text, option.value));
                    });
                    loadfirstmonth(); // Call after options are loaded
                } else {
                    console.error("Error in response:", response.message);
                    select.append(new Option('No options available', ''));
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching options:", error);
                alert("An error occurred while fetching options.");
            }
        });
    }

    loadSelectOptions();

    $(document).on('change', '.dynamicSelect', function() {
        var selectedValue = $(this).val(); 
        console.log("Selected Value: " + selectedValue);

        $.ajax({
            url: 'content/_handalanalysis.php',
            type: 'POST',
            data: { value: selectedValue },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    const categories = response.data.map(item => item.category);
                    const totalSpending = response.data.map(item => parseFloat(item.total_spending));
                    updateChart(categories, totalSpending);
                } else {
                    console.error('Error: ', response.message);
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    function updateChart(categories, totalSpending) {
        console.log("function categories: " + categories);
        console.log("function totalSpending: " + totalSpending);

        // If a chart instance exists, destroy it before creating a new one
        if (chartInstance) {
            chartInstance.destroy(); // Destroy existing chart instance
        }
      
        const chartOptions = {
            series: totalSpending,
            labels: categories,
            legend: { position: "bottom" },
            theme: { palette: "palette1" },
            chart: { type: "donut" },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: { fontSize: "22px", fontWeight: 600 },
                            value: {
                                fontSize: "16px", fontWeight: 400,
                                formatter(value) {
                                    return "₹" + value;
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter(value) {
                        return "₹" + value;
                    }
                }
            }
        };

        // Function to initialize the chart
        function initChart() {
            chartInstance = new ApexCharts(document.querySelector("#bsb-chart-4"), chartOptions);
            chartInstance.render(); // Render the chart
        }

        // Run when the page is ready
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initChart);
        } else {
            initChart();
        }
    }
});
