jQuery(document).ready(function($) {
    $( ".accordion" ).accordion({
      collapsible: true,
      active: true,
        header:"h4",
      heightStyle: "content"
    });
    /* 2 functions that can be used to vary tooltip width according to image width:
    dw_Tooltip.wrapImageToWidth and dw_Tooltip.wrapToWidth
    See www.dyn-web.com/code/tooltips/documentation2.php#wrapFn for info */
    dw_Tooltip.defaultProps = {
        //supportTouch: true, // set false by default
        wrapFn: dw_Tooltip.wrapImageToWidth
    }

    // Problems, errors? See http://www.dyn-web.com/tutorials/obj_lit.php#syntax

    dw_Tooltip.content_vars = {
        L1: {
            img: 'https://stage.alert.wsu.edu/wp-content/uploads/sites/1444/2016/08/login.png',
            w: 500, // width of image
            h: 500 // height of image

        },
        L2: {
            img: 'https://stage.alert.wsu.edu/wp-content/uploads/sites/1444/2016/08/mywsu.png',
            w: 500,
            h: 500
        },
        L3: {
            img: 'https://stage.alert.wsu.edu/wp-content/uploads/sites/1444/2016/08/report.png',
            w: 500,
            h: 500
        },
        L4: {
            img:'https://stage.alert.wsu.edu/wp-content/uploads/sites/1444/2016/08/studentemergencynotification.png',
            w: 500,
            h: 500
        },
        L5: {
            img: 'https://stage.alert.wsu.edu/wp-content/uploads/sites/1444/2016/08/thankyou.png',
            w: 500,
            h: 500
        }
    }

  });
