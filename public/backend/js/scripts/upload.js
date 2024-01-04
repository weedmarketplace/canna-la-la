var SUpload = function () {
    return {
        //main function to initiate the module
        init: function (options) {

            options = $.extend(true, {
              uploadContainer:false,
              token:false,
              temp:0,
              button:'uploadBtn',
              original:0,
              cover:false,
              map:false,
              blog:false,
              deal:false,
              collection:false,
              filename:0,
              imageIdReturnEl: '.upload_image'
            }, options);

            var uploadImageContainer = document.getElementById(options.uploadContainer);
            $(uploadImageContainer).find('.remove-image').on('click', function(e) {
                var removeImageId = $(uploadImageContainer).find(options.imageIdReturnEl).val();
                console.log('removeImageId -- '+removeImageId );
                if(removeImageId){
                      // console.log(options.token)
                      // Remove from server and db
                      $.ajax({
                        	type: "POST",
                        	url: "/admin/remove-image",
                        	dataType: 'JSON',
                        	data:{_token:options.token,imageId:removeImageId,cover:options.cover,map:options.map,blog:options.blog,deal:options.deal,collection:options.collection},
                        		success: function(response){
                              $(uploadImageContainer).find('.image-part img').attr('src','/backend/img/no_image.png');
                              console.log(options.deal);
                              if(!options.collection && !options.deal && !options.blog){
                                console.log("herer");
                                $(uploadImageContainer).find(options.imageIdReturnEl).val('');
                              }
                              $(uploadImageContainer).find('.image-action').removeClass('fileExist').addClass('fileNotExist');
                              if (options.onRemove) {
                                  options.onRemove.call(undefined, removeImageId);
                              }
                        		}
                        	});
                    }
            });
            var uploader = new ss.SimpleUpload({
                button: options.button,
                url: "/admin/upload-image", // server side handler
                responseType: 'json',
                name: 'file',
                method: 'POST',
                data: {'_token': options.token, 'temp': options.temp, 'cover': options.cover, 'blog': options.blog, 'deal': options.deal, 'map': options.map, 'original': options.original, 'collection': options.collection, 'filename': options.filename},
                allowedExtensions: ['jpg', 'jpeg', 'png', 'svg'],
                maxSize: 10240,
                hoverClass: 'ui-state-hover',
                focusClass: 'ui-state-focus',
                disabledClass: 'ui-state-disabled',
                startXHR: function(filename, size) {
                  // Loading.add($('#uploadBtn'));
                  Loading.add($('#'+options.button));
                },
                onComplete: function( filename, response ) {
                  if(response.status == 1){
                      if(options.original == 1){
                        var n = Date.now();
                        $(uploadImageContainer).find('.image-part img').attr('src',response.path+"?"+n);
                      }else if(options.collection != false){
                        $(uploadImageContainer).find('.image-part img').attr('src',response.path+"?"+n);
                        $(uploadImageContainer).find('.image-action').removeClass('fileNotExist').addClass('fileExist');
                      }else{
                        $(uploadImageContainer).find('.image-part img').attr('src',response.path);
                        $(uploadImageContainer).find('.image-action').removeClass('fileNotExist').addClass('fileExist');
                        if(response.imageId){
                          $(uploadImageContainer).find(options.imageIdReturnEl).val(response.imageId);
                        }
                        if (options.onSuccess) {
                          options.onSuccess.call(undefined, response.imageId);
                        }
                      }
                  }
                  if(response.status == 0){
                    toastr['error'](response.message, 'Error');
                  }

                  Loading.remove($('#'+options.button));
                  },
                endXHR: function(filename) {
                  Loading.remove($('#'+options.button));
                },
                startNonXHR: function(filename) {
                  Loading.remove($('#'+options.button));
                },
                endNonXHR: function(filename) {
                  Loading.remove($('#'+options.button));
                }

          });
        },

    };
};

