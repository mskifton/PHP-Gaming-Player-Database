$(document).ready(function() {
  var users = [
      "bladeboques",
      "macilus",
      "lacari",
      "Aionjanis",
      "MorrolanTV"
  ];

  $(".fa-plus-circle").on("click", function() {
    var add = $("input").val();
    if (add === "") alert("Enter a username");
    users.push(add);
    $(".user").remove();
    $("#online,#offline").html("");
    twitch(users);
  }); //button click to add new steamers. Will reset on refresh

  $("input").keyup(function(enter) {
    if (enter.keyCode == 13) {
      $(".fa-plus-circle").click();
    }
  }); //to add with enter

  $("#online,#offline").hide(); //hide the tabs till toggle

  $("li:first-child").click();

  twitch(users); //main function trigger

  function twitch(users) {
    $("input").val("");
    users.forEach(function(user) {
      var detailUrl = "https://wind-bow.glitch.me/twitch-api/channels/" + user; //Stream detail API

      $.getJSON(detailUrl, function(detail) {
        var streamUrl = "https://wind-bow.glitch.me/twitch-api/streams/" + user; //Stream status API

        $.getJSON(streamUrl, function(current) {
          var streamStat,
            game,
            img = detail.logo,
            link = detail.url,
            name = detail.display_name;

          if (img === null) {
            img = "https://www.twitch.tv/p/assets/uploads/glitch_474x356.png";
          } //to set a place holder for non existing images

          if (current.stream === null) {
            game = "OFFLINE";
            streamStat = "";
          } else {
            game = current.stream.channel.game+":";
            streamStat = current.stream.channel.status;
          }

          if (detail.status != 422 && detail.status != 404)
            putDetail(user, link, img, name, streamStat, game);
          else {
            alert(
              "Username is not registered with Twitch. Please check your spelling and try again."
            );
            users.pop();
          }

          if (game == "OFFLINE") putOffline(user);
          else putOnline(user);

          $(".user").on("mouseover", function() {
            $(this).find("figcaption").css("left", "0%");
          });

          $(".user").on("mouseout", function() {
            $("figcaption").css("left", "-240px");
          });
        }); //stream url JSON ends
      }); //detailUrl JSON
    }); //forEach function
  }

  $("li").on("click", function() {
    var id = $(this).attr("data-stat"),
      somear = ["streamers", "online", "offline"];
    $("li").css("background-color", "rgba(255,255,255,0.6)");
    $(this).css("background-color", "white");
    for (var i = 0; i < somear.length; i++) {
      $("#" + somear[i]).show();
    }
    for (i = 0; i < somear.length; i++) {
      if (somear[i] != id) {
        $("#" + somear[i]).hide();
      }
    }
  }); //fn for tabbed navigation

  function putDetail(user, link, img, name, stat, game) {
    $("#streamers").append("<div class='user' id=" + user + "></div>");
    $("#" + user).append(
      "<a href=" +
        link +
        " target='_blank'><div><strong>" +
        name +
        "</strong><figure><img src=" +
        img +
        "><figcaption>" +
        game +
        "<br><br>" +
        stat +
        "</figcaption></figure></div></a>"
    );
  } //fn putDetail ends. This fn creates the cards and inserts the details

  function putOnline(user, game) {
    $("#" + user).append("<div class='status greenbg'>Online</div>");
    $("#" + user).clone().appendTo("#online");
  } //fn putOnline ends. This fn puts the online under the picture

  function putOffline(user) {
    $("#" + user).append("<div class='status graybg'>Offline</div>");
    $("#" + user).clone().appendTo("#offline"); //
  } //fn putOffline ends. This fn puts the offline under the picture
}); //document ready ends