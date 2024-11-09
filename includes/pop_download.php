<!-- popup.php -->
<style>
    /* Styling for the popup */
    #uploadPopup {
        display: none; /* Hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3); /* Softer dark overlay */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    #uploadPopupContent {
        background-color: white;
        padding: 30px; /* Increased padding for more space inside the popup */
        border-radius: 12px; /* Rounded corners to match theme */
        text-align: center;
        max-width: 350px; /* Slightly larger width */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Softer shadow for depth */
        border: 2px solid #d4a24c; /* Light golden border for elegance */
    }

    #uploadPopupContent p {
        font-size: 18px; /* Slightly larger text for better readability */
        color: #333; /* Darker text for readability */
        font-weight: 500; /* Medium font-weight to match style */
        font-family: Arial, sans-serif;
        margin-bottom: 20px;
    }

    .popup-button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 45px; /* Slightly larger button size */
        height: 45px;
        font-size: 22px; /* Slightly larger icon/text */
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        margin: 0 10px;
        transition: background-color 0.3s ease;
    }

    .popup-button.accept {
        background-color: #4CAF50; /* Green for confirm */
    }

    .popup-button.accept:hover {
        background-color: #45a049; /* Darker green on hover */
    }

    .popup-button.decline {
        background-color: #f44336; /* Red for cancel */
    }

    .popup-button.decline:hover {
        background-color: #e33528; /* Darker red on hover */
    }
</style>

<div id="uploadPopup">
    <div id="uploadPopupContent">
        <p>Download 4 SOA files?</p>
        <button class="popup-button accept" onclick="closeUploadPopup()">✔</button>
        <button class="popup-button decline" onclick="closeUploadPopup()">✖</button>
    </div>
</div>

<script>
    // Function to show the popup
    function showUploadPopup() {
        document.getElementById("uploadPopup").style.display = "flex";
    }

    // Function to close the popup
    function closeUploadPopup() {
        document.getElementById("uploadPopup").style.display = "none";
    }
</script>