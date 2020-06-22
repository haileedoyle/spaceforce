var AdStanding = AdStanding || {};
AdStanding.window = AdStanding.window || window;
AdStanding.document = AdStanding.document || window.document;

(function() {
  var frames = [];

  if (window.top != window.self && AdStanding.disableFriendlyIframe !== true)
  {
    try
    {
      if (window.top.AdStanding)
      {
        AdStanding = window.top.AdStanding;
      }
      else
      {
        window.top.AdStanding = AdStanding;
        AdStanding.window = window.top;
        AdStanding.document = window.top.document;
      }

      var parent = window.frameElement;
      while (parent)
      {
        frames.push(parent);
        parent = parent.frameElement;
      }
    }
    catch (e)
    {
      // console.log('parent iframe not friendly for zone: ' + 7716 );
    }
  }

  AdStanding.server = "adserve.atedra.com";
  AdStanding.lib_server = "code.adstanding.com";
  AdStanding.accelerated_zones = 3;

  AdStanding.zones = AdStanding.zones || [];
  AdStanding.processed = AdStanding.processed || false;
  AdStanding.acceleration_processed = AdStanding.acceleration_processed || false;

  var iframeId = "adstanding_iframe_7716_" + new Date().getTime() + "_" + parseInt(Math.random() * 100000, 10);

  document.write('<iframe id="' + iframeId + '" width="0" height="0" style="display:none;" scrolling="no" frameborder="0"></iframe>');

  var zone = {
    window: window,
    frames: frames,
    html_id: iframeId,
    zone_id: 7716,
    placement_id: 0,
    click_tracker: null,
    loaded: false,
    accelerated: true,
    rendered: false,
    is_refreshing: false,
    skip: false,
  }


  // Video wrapper init
  var AtedraVideo = window.AtedraVideo || AdStanding.window.AtedraVideo;

  if (typeof AtedraVideo !== "undefined") {
    AtedraVideo.type = null;
    AtedraVideo.video_id = null;

    zone.video = cloneVideo(AtedraVideo);
    resetVideo(AtedraVideo);
  }

  AdStanding.zones.push(zone);

  
  var script = AdStanding.document.getElementById("adstanding_requirejs");

  if (script === null)
  {
    var s = AdStanding.document.createElement("script");
    s.type = "text/javascript";
    s.src = 'https://' + AdStanding.lib_server + '/js/lib/requireJS-2.1.11.js';
    s.id = 'adstanding_requirejs';

    if(AdStanding.document.head)
    {
      AdStanding.document.head.appendChild(s);
    }
    else
    {
      AdStanding.document.body.appendChild(s);
    }
  }
  else
  {
    if (AdStanding.loaded)
    {
      AdStanding.execute();
    }
  }

  // Video wrapper helpers
  function cloneVideo(source)
  {
    clone = {};
    clone.zone_id = source.zone_id;
    clone.type = source.type;
    clone.video_id = source.video_id;
    clone.width = source.width;
    clone.height = source.height;
    clone.params = source.params;
    clone.flashvars = source.flashvars;
    clone.attributes = source.attributes;
    clone.thumbnail_url = source.thumbnail_url;
    clone.demo = source.demo;
    clone.tbcc = source.tbcc;
    clone.sfp = source.sfp;
    clone.async = source.async;
    clone.onFinish = source.onFinish;
    return clone;
  }

  function resetVideo(video)
  {
    delete video.zone_id;
    delete video.type;
    delete video.video_id;
    delete video.width;
    delete video.height;
    delete video.params;
    delete video.flashvars;
    delete video.attributes;
    delete video.thumbnail_url;
    delete video.demo;
    delete video.tbcc;
    delete video.sfp
    delete video.async;
    delete video.onFinish;
  }
})();
