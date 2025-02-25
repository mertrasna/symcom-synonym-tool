$(document).ready(function () {
    // form validation
    
    var addAutorenForm = $("#addAutorenForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            'nachname': "required",
            'code': "required"
        },
        messages: {
            'nachname': "Nachname ist eine Pflichtangabe",
            'code': "Abbreviation ist eine Pflichtangabe"
        }
    });
	var changePassword = $("#changePassword").validate({
		errorPlacement: function(error, element) {
		error.appendTo(element.prev("span"));
		},
		rules: {
            current_password: {
                required: true,
                minlength: 6
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo : "#password"
            }
        },     
        messages: {
            current_password: {
                required: "Derzeitiges Passwort ist eine Pflichtangabe",
                minlength: "Ihr aktuelles Passwort muss aus 6 Zeichen bestehen" 
            },
            password: {
                required: "Neues Passwort ist eine Pflichtangabe",
                minlength: "Ihr aktuelles Passwort muss aus 6 Zeichen bestehen" 
            },
            password_confirmation: {
                required: "Bestätige neues Passwort ist eine Pflichtangabe",
                minlength: "Ihr aktuelles Passwort muss aus 6 Zeichen bestehen" ,
                equalTo : "Passwort stimmt nicht überein !!!"
            } 
        }
	});

	var changeEmail = $("#changeEmail").validate({
		errorPlacement: function(error, element) {
		error.appendTo(element.prev("span"));
		},
		rules: {
            email: {
                required: true,
                email: true
            }
        },     
        messages: {
            email: {
                required: "Email ist eine Pflichtangabe",
                email: "Bitte geben Sie eine gültige Email-Adresse ein" 
            }
        }
	});

    var addHerkunftForm = $("#addHerkunftForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            code: {
                required: true
            },
            titel: {
                required: true
            }
        },     
        messages: {
            code: {
                required: "Code ist eine Pflichtangabe"
            },
            titel: {
                required: "Titel ist eine Pflichtangabe"
            }
        }
    });

    var addSourceReferenceForm = $("#addSourceReferenceForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            titel: {
                required: true
            }
        },     
        messages: {
            titel: {
                required: "Titel ist eine Pflichtangabe"
            }
        }
    });

    var addSynonymDeForm = $("#addSynonymDeForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            word: {
                required: true
            },
            synonym: {
                required: true
            }
        },     
        messages: {
            word: {
                required: "Wort ist Pflicht"
            },
            synonym: {
                required: "Striktes Synonym ist obligatorisch"
            }
        }
    });

    var addSynonymEnForm = $("#addSynonymEnForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            word: {
                required: true
            },
            synonym: {
                required: true
            }
        },     
        messages: {
            word: {
                required: "Wort ist Pflicht"
            },
            synonym: {
                required: "Striktes Synonym ist obligatorisch"
            }
        }
    });

    var addVerlageForm = $("#addVerlageForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            titel : {
                required: true
            },
            email: {
                email: true
            }
        },     
        messages: {
            titel : {
                required: "Titel ist eine Pflichtangabe"
            },
            email: {
                email: "Bitte geben Sie eine gültige Email-Adresse ein" 
            }
        }
    });

    var addQuelleForm = $("#addQuelleForm").validate({
        errorPlacement: function(error, element) {
            error.appendTo(element.prev("span"));
        },
        // view.
        highlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.is(".select2-hidden-accessible, .required")) {
                elem.next().find("ul.select2-selection__rendered").addClass(errorClass);
            } else {
                elem.addClass(errorClass);
            }
        },

        //When removing make the same adjustments as when adding
        unhighlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.is(".select2-hidden-accessible, .required")) {
                elem.next().find(".select2-selection__rendered").removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        },
        rules: {
            // 'code': "required",
            'titel': "required",
            'sprache': "required",
            'jahr': "required",
            'autor_id[]': "required",
            /*'auflage': "required"*/
            /*'verlag_id': "required"*/
            'title_abbreviation_1': "required"
        },
        messages: {
            // 'code': "Kurzel ist eine Pflichtangabe",
            'titel': "Titel ist eine Pflichtangabe",
            'sprache': 'Sprache ist eine Pflichtangabe',
            'jahr': "Jahr ist eine Pflichtangabe",
            'autor_id[]': "Autor ist eine Pflichtangabe",
            /*'auflage': "Auflage ist eine Pflichtangabe"*/
            /*'verlag_id': "Verlag ist eine Pflichtangabe"*/
            'title_abbreviation_1': "Title abbreviation 1 ist eine Pflichtangabe"
        }
    });

    var addZeitschriftForm = $("#addZeitschriftForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        // view.
        highlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.is(".select2-hidden-accessible, .required")) {
                elem.next().find(".select2-selection__rendered").addClass(errorClass);
            } else {
                elem.addClass(errorClass);
            }
        },

        //When removing make the same adjustments as when adding
        unhighlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.is(".select2-hidden-accessible, .required")) {
                elem.next().find(".select2-selection__rendered").removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        },
         rules: {
            // 'code': "required",
            'titel': "required",
            'sprache': "required",
            'jahr': "required",
            // 'autor_id[]': "required",
            'title_abbreviation_1': "required"
        },
        messages: {
            // 'code': "Kurzel ist eine Pflichtangabe",
            'titel': "Titel ist eine Pflichtangabe",
            'sprache': 'Sprache ist eine Pflichtangabe',
            'jahr': "Jahr ist eine Pflichtangabe",
            // 'autor_id[]': "Autor ist eine Pflichtangabe",
            'title_abbreviation_1': "Title abbreviation 1 ist eine Pflichtangabe"
        }
    });

    $(document).on("change", "#addZeitschriftForm .select2-hidden-accessible", function () {
        if (!$.isEmptyObject(addZeitschriftForm.submitted)) {
            addZeitschriftForm.form();
        }
    });
     $(document).on("#addZeitschriftForm select2-opening", function (arg) {
        var elem = $(arg.target);
        if ($("#addZeitschriftForm .select2-selection__rendered").hasClass("error")) {
            //jquery checks if the class exists before adding.
            $("#addZeitschriftForm .select2-drop ul").addClass("error");
        } else {
            $("#addZeitschriftForm .select2-drop ul").removeClass("error");
        }
    });

    var addArzneiForm = $("#addArzneiForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            'titel': "required",
        },
        messages: {
            'titel': "Arznei ist eine Pflichtangabe"
        }
    });

    var addBenutzerForm = $("#addBenutzerForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: { 
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            username: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo : "#password"
            },
            user_type: {
                required: true
            }
        },     
        messages: {
            first_name: {
                required: "Vorname ist eine Pflichtangabe"
            },
            last_name: {
                required: "Nachname ist eine Pflichtangabe"
            },
            username: {
                required: "Nachname ist eine Pflichtangabe"
            },
            email: {
                required: "Email ist eine Pflichtangabe",
                email: "Bitte geben Sie eine gültige Email-Adresse ein" 
            },
            password: {
                required: "Passwort ist eine Pflichtangabe",
                minlength: "Ihr aktuelles Passwort muss aus 6 Zeichen bestehen" 
            },
            password_confirmation: {
                required: "Bestätige Passwort ist eine Pflichtangabe",
                minlength: "Ihr aktuelles Passwort muss aus 6 Zeichen bestehen" ,
                equalTo : "Passwort stimmt nicht überein !!!"
            },
            user_type: {
                required: "Benutzertyp ist eine Pflichtangabe"
            }
        }
    });


    var editBenutzerForm = $("#editBenutzerForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: { 
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            username: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo : "#password"
            },
            user_type: {
                required: true
            }
        },     
        messages: {
            first_name: {
                required: "Vorname ist eine Pflichtangabe"
            },
            last_name: {
                required: "Nachname ist eine Pflichtangabe"
            },
            username: {
                required: "Nachname ist eine Pflichtangabe"
            },
            email: {
                required: "Email ist eine Pflichtangabe",
                email: "Bitte geben Sie eine gültige Email-Adresse ein" 
            },
            password: {
                minlength: "Ihr aktuelles Passwort muss aus 6 Zeichen bestehen" 
            },
            password_confirmation: {
                minlength: "Ihr aktuelles Passwort muss aus 6 Zeichen bestehen" ,
                equalTo : "Passwort stimmt nicht überein !!!"
            },
            user_type: {
                required: "Benutzertyp ist eine Pflichtangabe"
            }
        }
    });

    var addquellenimportForm = $("#addquellenimportForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            arznei_id : {
                required: true
            },
            quelle_id : {
                required: true
            },
            symptomtext: {
                required: true
            }
        },     
        messages: {
            arznei_id : {
                required: "Arznei ist eine Pflichtangabe"
            },
            quelle_id : {
                required: "Quelle ist eine Pflichtangabe"
            },
            symptomtext: {
               required: "Symptomtext ist eine Pflichtangabe"
            }
        }
    });

    // reference form
    var addReferenceForm = $("#addReferenceForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            'full_reference': "required",
        },
        messages: {
            'full_reference': "Reference ist eine Pflichtangabe"
        }
    });

    // quelleSettingsForm form
    var quelleSettingsForm = $("#quelleSettingsForm").validate({
        errorPlacement: function(error, element) {
        error.appendTo(element.prev("span"));
        },
        rules: {
            'quelle_settings_quelle_id': "required",
        },
        messages: {
            'quelle_settings_quelle_id': "Quelle ist eine Pflichtangabe"
        }
    });

});