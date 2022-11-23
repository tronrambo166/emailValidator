/*!
 * Alan Da Silva - Viwari (https://codecanyon.net/user/viwari/portfolio)
 * Copyright 2017 Berevi Collection
 * Licensed (https://codecanyon.net/licenses/standard)
 * See full license https://codecanyon.net/licenses/terms/regular
 */

/* select input */
$(document).ready(function() {
    $('.cleaning-choices').select2({
        theme: "bootstrap",
        placeholder: "Select an option",
        width: "resolve",
        minimumResultsForSearch: Infinity
    });
    $('.aeo-tld').select2({
        theme: "bootstrap",
        placeholder: "Choose domains to remove from your list",
        width: "resolve",
        minimumResultsForSearch: 4,
        tags: true
    });
    $('.aeo-sld').select2({
        theme: "bootstrap",
        placeholder: "Choose domains to remove from your list",
        width: "resolve",
        minimumResultsForSearch: 4,
        tags: true
    });
    $('.select2-search__field').css('width','100%');
});

/* Tutorial */
$(function() {
    var $start = $('.start'), 
    tour = new Tour({
        storage : window.localStorage,
        debug: false,
        backdrop: true,
        backdropContainer: 'body',
        backdropPadding: 10,
        autoscroll: true,
        template:
        "<div class='popover tour project-tour'>" +
            "<div class='arrow'></div>" +
            "<h3 class='popover-title'></h3>" +
            "<div class='popover-content'></div>" +
            "<div class='popover-navigation'><hr>" +
                "<div class='btn-group'>" +
                    "<button class='btn btn-sm btn-primary' data-role='prev'>« Prev</button>" +
                    "<button class='btn btn-sm btn-primary' data-role='next'>Next »</button>" +
                "</div>" +
                "<button class='btn btn-sm btn-danger' data-role='end'>End tour</button>" +
            "</div>" +
        "</div>",
        onStart: function() {},
        onEnd: function() {
            $start.removeClass('disabled', true);
        }
    });

    tour.addStep({
        title:   "<h4 class='brv-popover-title'>Welcome to Optimail Cleaner</h4>",
        content: "<br><p>This is your first use, so we will explain all the features offered by Optimail Cleaner.</p>" + 
                 "<p class='brv-popover-content'>At any time you can leave this guide by clicking on the &laquo;End tour&raquo; button.<br><br>" + 
                 "Here's a few tips to help you get started.</p>",
        orphan: true
    });

    tour.addStep({
        element: "#download",
        title:   "<h4 class='brv-popover-title'>The control buttons</h4>",
        content: "<br><p class='brv-popover-content'>These buttons offer more features as the ability " + 
                 "to launch the tutorial at any time (yes that you're reading now), " + 
                 "the bounce mails panel (to get them directly from your mailbox), " + 
                 "and the records table of all the files you have cleaned.</p>",
        onShow: function () {
            $("#tour-bm").prop("disabled", true);
            $("#menu-toggle").prop("disabled", true);
            $(".start").prop("disabled", true);
            $("#tour").prop("disabled", true);
        },
        onHide: function () {
            $("#tour-bm").prop("disabled", false);
            $("#menu-toggle").prop("disabled", false);
            $(".start").prop("disabled", false);
            $("#tour").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#usage",
        title:   "<h4 class='brv-popover-title'>The file name</h4>",
        content: "<br><p class='brv-popover-content'>This is the name of the file used during the backup such as list1 for example.</p>",
        placement: "bottom",
        onShow: function () {
            $("#inputListName").prop("disabled", true);
        },
        onHide: function () {
            $("#inputListName").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#options",
        title:   "<h4 class='brv-popover-title'>Paste your emails</h4>",
        content: "<br><p class='brv-popover-content'>You can add email addresses for cleaning directly " + 
                 "by pasting them here, one per line without any other characters.</p>",
        placement: "bottom",
        onShow: function () {
            $("#textareaListEmails").prop("disabled", true);
        },
        onHide: function () {
            $("#textareaListEmails").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#reflex",
        title:   "<h4 class='brv-popover-title'>Upload a txt or csv file</h4>",
        content: "<br><p class='brv-popover-content'>You can add here a text or csv file containing your email addresses. " + 
                 "This file must contain one address per line. It's possible to paste your email addresses in the previous " + 
                 "step and upload a file here at the same time.</p>",
        placement: "bottom",
        onShow: function () {
            $("#file-input").prop("disabled", true);
        },
        onHide: function () {
            $("#file-input").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#contributing",
        title:   "<h4 class='brv-popover-title'>The cleaning level</h4>",
        content: "<br><p class='brv-popover-content'>This is where you decide which level you want to choose to clean your email addresses. " + 
                 "Each level of cleaning resumes the previous level.<br><br>" + 
                 "<b>Level 1 is about validating emails</b>, this means verify the addresses syntactically.<br>" + 
                 "<b>Level 2 is about domain validation</b>, this means check the domain name of each email and see if it exists.<br>" + 
                 "<b>Level 3 is about SMTP email validation</b>, this means check at the source if the email address actually exist.<br><br>" + 
                 "<b>It should be noted</b> that the use of <b>Level 3</b> must be done in the best conditions as possible. " + 
                 "Your IP address should not be blacklisted or have a poor reputation, nor should you be " + 
                 "in localhost, behind a proxy or a shared network.</p>",
        placement: "right",
        onShow: function () {
            $("#select-choices").prop("disabled", true);
        },
        onHide: function () {
            $("#select-choices").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#order-1",
        title:   "<h4 class='brv-popover-title'>Ascending or descending?</h4>",
        content: "<br><p class='brv-popover-content'>The ASC or DESC option allows you to indicate the order of sorts. " + 
                 "ASC corresponds then to ascending sort and DESC to descending sort.</p>",
        placement: "left",
        onShow: function () {
            $("#noSorting").prop("disabled", true), 
            $("#ascOrder").prop("disabled", true), 
            $("#descOrder").prop("disabled", true);
        },
        onHide: function () {
            $("#noSorting").prop("disabled", false), 
            $("#ascOrder").prop("disabled", false), 
            $("#descOrder").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#order-2",
        title:   "<h4 class='brv-popover-title'>Sort by domains</h4>",
        content: "<br><p class='brv-popover-content'>Here you have the possibility to sort your email addresses by endings " + 
                 "(eg: .com, .org, .ca, .lu, gmail.com, domain.com...).</p>",
        placement: "left",
        onShow: function () {
            $("#noDomain").prop("disabled", true), 
            $("#tld").prop("disabled", true), 
            $("#ccTld").prop("disabled", true),
            $("#sld").prop("disabled", true);
        },
        onHide: function () {
            $("#noDomain").prop("disabled", false), 
            $("#tld").prop("disabled", false), 
            $("#ccTld").prop("disabled", false),
            $("#sld").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#del-tld",
        title:   "<h4 class='brv-popover-title'>TLD and ccTLD removal</h4>",
        content: "<br><p class='brv-popover-content'>You can decide to delete from your list when cleaning the email addresses " + 
                 "ending with the chosen options. You have at your disposal a very complete list of choices but if this is not enough " + 
                 "you can create your own tags by directly tapping them in.</p>",
        placement: "left",
        onShow: function () {
            $("#aeo-tld").prop("disabled", true);
        },
        onHide: function () {
            $("#aeo-tld").prop("disabled", false);
        }
    });

    tour.addStep({
        element: "#del-sld",
        title:   "<h4 class='brv-popover-title'>SLD removal</h4>",
        content: "<br><p class='brv-popover-content'>This option fulfills exactly the same roles as the previous step, " + 
                 "except that the deletion concerns SLD domains such as yahoo.com, gmail.com, domain.com... " + 
                 "Aslo provided with a complete list of choices.</p>",
        placement: "left",
        onShow: function () {
            $("#aeo-sld").prop("disabled", true);
        },
        onHide: function () {
            $("#aeo-sld").prop("disabled", false);
        },
    });

    tour.addStep({
        title:   "<h4 class='brv-popover-title'>That's it!</h4>",
        content: "<br><p class='brv-popover-content'>We did a quick tour together but there is still a lot to discover by yourself. " + 
                 "At any time, you can click on the &laquo;Tutorial&raquo; button to restart this guide.</p>",
        orphan: true,
        onShow: function () {
            $('html, body').animate({
                scrollTop : 0
            }, 1000);

            return false;
        }
    });

    tour.start();

    $(document).on('click','.start:not(.disabled)', function(e) {
        e.preventDefault();
        tour.restart();
        $('.alert').alert('close');
    });
});
