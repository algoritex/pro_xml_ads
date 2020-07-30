jQuery(document).ready(function () {
    $("#custom_field_button").click(function () {
        var e = ($("#custom_fields .form-controls").length + 1, ""), r = '<div class="form-controls"><<input id="custom_field[]" name="custom_field[]"  type="text" placeholder="' + e + '" />></div></div>';
        $("#custom_fields").append(r)
    });
    var e = $("#xml_form");
    e.validate({
        errorClass: "error_validate",
        validClass: "ok_validate",
        rules: {
            xml_feed: {
                required: function () {
                    var e = $("#uploaded_xml").val();
                    return 0 == e.length ? !0 : void 0
                }
            }, uploaded_xml: {
                required: function () {
                    var e = $("#xml_feed").val();
                    return 0 == e.length ? !0 : void 0
                }
            }, title_tag: "required", description_tag: "required", email: {
                required: function () {
                    var e = $("#email_tag").val();
                    return 0 == e.length ? !0 : void 0
                }
            }, email_tag: {
                required: function () {
                    var e = $("#email").val();
                    return 0 == e.length ? !0 : void 0
                }
            }, category: {
                required: function () {
                    var e = $("#category_tag").val();
                    return 0 == e.length ? !0 : void 0
                }
            }, category_tag: {
                required: function () {
                    return "0" == $("#category").val() ? !0 : void 0
                }
            }
        },
        messages: {
            xml_feed: {required: "required"},
            title_tag: {required: "required"},
            description_tag: {required: "required"},
            email: {required: "required this field or email_tag", email: "please, enter a correct email format"},
            email_tag: {
                required: "required this field or a default email",
                email: "please, enter a correct email format"
            },
            category: {required: "required this field or category_tag"},
            category_tag: {required: "required this field or select a default category"}
        }
    }), $(".checkbox_custom_tag").change(function () {
        $(".checkbox_custom_tag").attr("checked") ? $(".custom_tags").hide() : $(".custom_tags").show()
    })
});