// Function to initialize the chart with dynamic max balance and green/red colors
function initChart(balanceData, spendingData, months, maxBalance) {
    const chartData = {
        series: [
            { name: "Spending", data: spendingData},
            { name: "Balance", data: balanceData }
        ],
        chart: {
            type: "bar",
            toolbar: { show: false }
        },
        colors: ["var(--bs-primary)", "var(--bs-primary-bg-subtle)"],
        states: {
            hover: { filter: { type: "darken", value: 0.9 } }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: { enabled: false },
        legend: { position: "bottom" },
        xaxis: { categories: months },
        yaxis: {
            title: { text: "$ (thousands)" }
        },
        tooltip: {
            theme: "dark",
            y: { formatter: (value) => "₹ " + value + " thousands" }
        }
    };
    // Create and render the chart
    const chart =   new ApexCharts(document.querySelector("#bsb-chart-5"), chartData).render();
}

// AJAX function to get data from the PHP file
function fetchMonthlyData() {
    $.ajax({
        url: 'content/_handlecompair_monthly.php', 
        type: 'POST', // Assuming POST request
        dataType: 'json', // Expecting a JSON response
        success: function(response,data) {
            console.log(data);
            if (response.status === 'success') {
                const spendingData = response.spending_data;
                const balanceData = response.balance_data;
                const months = response.months;
                const maxBalance = response.max_balance;

                // Initialize the chart with fetched data
                initChart(balanceData, spendingData, months, maxBalance);
            } else {
                console.error("Error: ", response.errors);
            }
        },
        error: function(data) {
            // console.error("AJAX Error: ", error);
            console.log(data);
        }
    });
}

// Call the fetchMonthlyData function when the document is ready
document.addEventListener("DOMContentLoaded", fetchMonthlyData);
