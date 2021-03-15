<!DOCTYPE html>
<html lang="en">
<head> 
  <title>Profile</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.html') ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Profile Info</h1>
        </div>
        <div class="grid-row">
            <form name="profile-form">
                <div class="form-group" id="profile-info">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="Jeremy Candor" disabled />
                    
                    <label for="email">Email Address</label>
                    <input type="text" class="form-control" id="email" value="JCBuckets@example.com" disabled />

                    <label for="team">Current Team</label>
                    <input type="text" class="form-control" id="team" value="The Three Bucketeers" disabled />
                </div>
                <button class="btn-grid" onclick="editProfile()">
                    Edit Profile
                </button>
            </form>
        </div>
    </div>

    <script>
        function editProfile() {
            var inputElements = document.getElementById("profile-info").getElementsByClassName("form-control");
            for (inputElement of inputElements) {
                inputElement.removeAttribute("disabled");
                inputElement.value = "YO";
            }
        }
    </script>
</body>
</html>