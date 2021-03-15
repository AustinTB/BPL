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
            <div class="form-group" id="profile-info">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" value="Jeremy Candor" disabled />
                
                <label for="email">Email Address</label>
                <input type="text" class="form-control" id="email" value="JCBuckets@example.com" disabled />

                <label for="team">Current Team</label>
                <input type="text" class="form-control" id="team" value="The Three Bucketeers" disabled />
                
                <button class="btn-grid" id="editButton" onclick="toggleEdit()">Edit Profile</button>
            </div>
        </div>
    </div>

    <script>
        var disabled = true;

        var toggleInput = (element) => {
            if (disabled == true) {
                element.removeAttribute("disabled");
            } else {
                element.setAttribute("disabled", "true");
            }
        };

        function toggleEdit() {
            var inputElements = document.getElementById("profile-info").getElementsByClassName("form-control");
            var button = document.getElementById("editButton");

            for (element of inputElements) {
                toggleInput(element);
            }

            if (disabled == true) {
                button.innerHTML = "Save Profile";
                disabled = false;

            } else {
                button.innerHTML = "Edit Profile";
                disabled = true;
            }
        }
    </script>
</body>
</html>