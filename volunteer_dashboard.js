$(document).ready(function() {
    $(".confirmPickupBtn").click(function() {
        let foodId = $(this).data("food-id");
        let volunteerId = $("#volunteer_id").val();

        if (!foodId || !volunteerId) {
            alert("❌ Missing food ID or volunteer ID.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "confirm_pickup.php",
            data: { food_id: foodId, volunteer_id: volunteerId },
            dataType: "html",
            success: function(response) {
                $("#result").html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("❌ Error confirming pickup.");
            }
        });
    });
});
