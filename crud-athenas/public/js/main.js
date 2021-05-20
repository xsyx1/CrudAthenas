(function ($) {
    "use strict";

    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window["pdfjs-dist/build/pdf"];
    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        "https://mozilla.github.io/pdf.js/build/pdf.worker.js";

    $body = $("body");
    let url = window.location;

    activeMenu(url);

    loadPdf();

    $body = $("body");
    var $sidebar = $(".sidebar");

    $sidebar.on("show.bs.collapse", ".collapse", function () {
        if (!$(this).hasClass("show")) {
            var $li = $(this).parent();
            var $openNav = $li.siblings().find(".collapse.show");
            $openNav.collapse("hide");
        }
    });

    $(document).on({
        ajaxStart: function () {
            $body.addClass("loading");
        },
        ajaxStop: function () {
            $body.removeClass("loading");
        },
    });

    $("input[required], select[required], textarea[required]")
        .siblings("label")
        .addClass("required");

    $(".cep").mask("00000-000");
    $(".cpf").mask("000.000.000-00", {
        reverse: true,
    });
    $(".cnpj").mask("00.000.000/0000-00", {
        reverse: true,
    });

    $(".money").mask("0.000.000,00", {
        reverse: true,
    });

    $(".percentage").mask("000,00", {
        reverse: true,
    });

    $(".area").mask("0000000,00", {
        reverse: true,
    });

    $(".insc_estadual").mask("000.000.000.000", {
        reverse: true,
    });

    $(".bank_account").mask("00000000000-0", {
        reverse: true,
    });

    $(".time").mask("00:00");
    $(".free_phone").mask("0000 000 0000");

    $(document).on("focus", ".money", function () {
        $(this).mask("0.000.000,00", {
            reverse: true,
        });
    });

    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, "").length === 11
                ? "(00) 00000-0000"
                : "(00) 0000-00009";
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            },
        };

    $(".phone").mask(SPMaskBehavior, spOptions);

    var cpfMascara = function (val) {
            return val.replace(/\D/g, "").length > 11
                ? "00.000.000/0000-00"
                : "000.000.000-009";
        },
        cpfOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(cpfMascara.apply({}, arguments), options);
            },
        };

    $(".cpf_cnpj").mask(cpfMascara, cpfOptions);

    $("#image").change(function () {
        var imgPath = $(this)[0].value;
        var ext = imgPath.substring(imgPath.lastIndexOf(".") + 1).toLowerCase();
        if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
            window.utilities.readUrl(this);
        else
            alert("Por favor, selecione o arquivo de imagem (jpg, jpeg, png).");
    });

    $(".select2").select2({
        language: "pt-BR",
        width: "100%",
    });

    $("#inp-city_id, .city").select2({
        minimumInputLength: 3,
        language: "pt-BR",
        placeholder: "Selecione a Cidade",
        width: "100%",
        ajax: {
            cache: true,
            url: getUrl() + "/api/v1/cities",
            dataType: "json",
            data: function (params) {
                var query = {
                    search: params.term,
                };
                return query;
            },
            processResults: function (response) {
                var results = [];

                $.each(response.data, function (i, v) {
                    var o = {};
                    o.id = v.id;
                    o.text = v.title + " - " + v.letter;
                    o.value = v.id;
                    results.push(o);
                });
                return {
                    results: results,
                };
            },
        },
    });

    $("#inp-profession_id").select2({
        minimumInputLength: 3,
        language: "pt-BR",
        placeholder: "Selecione...",
        width: "100%",
        ajax: {
            cache: true,
            url: getUrl() + "/api/v1/professions",
            dataType: "json",
            data: function (params) {
                var query = {
                    search: params.term,
                };
                return query;
            },
            processResults: function (data) {
                var results = [];

                $.each(data, function (i, v) {
                    var o = {};
                    o.id = v.id;
                    o.text = v.description;
                    o.value = v.id;
                    results.push(o);
                });
                return {
                    results: results,
                };
            },
        },
    });

    $(".btn-delete").on("click", function (e) {
        e.preventDefault();
        var form = $(this).parents("form").attr("id");
        swal({
            title: "Você está certo?",
            text:
                "Uma vez deletado, você não poderá recuperar esse item novamente!",
            icon: "warning",
            buttons: true,
            buttons: ["Cancelar", "Excluir"],
            dangerMode: true,
        }).then((isConfirm) => {
            if (isConfirm) {
                document.getElementById(form).submit();
            } else {
                swal("Este item está salvo!");
            }
        });
    });

    $(".btn-add").on("click", function () {
        var $tr = $(".dynamic-form");
        var $clone = $tr.clone();
        $clone.show();
        $clone.removeClass("dynamic-form");
        $clone.find("input,select").val("");
        $(".table-dynamic tbody").append($clone);
    });

    $(".multi-select").bootstrapDualListbox({
        nonSelectedListLabel: "Disponíveis",
        selectedListLabel: "Selecionados",
        filterPlaceHolder: "Filtrar",
        filterTextClear: "Mostrar Todos",
        moveSelectedLabel: "Mover Selecionados",
        moveAllLabel: "Mover Todos",
        removeSelectedLabel: "Remover Selecionado",
        removeAllLabel: "Remover Todos",
        infoText: "Mostrando Todos - {0}",
        infoTextFiltered:
            '<span class="label label-warning">Filtrado</span> {0} DE {1}',
        infoTextEmpty: "Sem Dados",
        moveOnSelect: false,
    });

    $(document).delegate(".btn-remove", "click", function (e) {
        e.preventDefault();
        swal({
            title: "Você esta certo?",
            text: "Deseja remover esse item mesmo?",
            icon: "warning",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                if ($(this).closest("tr").hasClass("remove")) {
                    $(this).closest("tr").hide();
                    $(this).siblings("input").val(1);
                } else {
                    $(this).closest("tr").remove();
                }
            }
        });
    });

    $(".pdf-input").on("change", function (e) {
        var file = e.target.files[0];
        var canvas = $(this).closest("div").siblings("canvas")[0];
        var context = canvas.getContext("2d");
        var validImageTypes = [
            "image/gif",
            "image/jpeg",
            "image/png",
            "image/jpg",
        ];
        if (file.type == "application/pdf") {
            if (file.size <= 2048000) {
                var fileReader = new FileReader();
                fileReader.onload = function () {
                    var pdfData = new Uint8Array(this.result);
                    // Using DocumentInitParameters object to load binary data.
                    var loadingTask = pdfjsLib.getDocument({
                        data: pdfData,
                    });
                    loadingTask.promise.then(
                        function (pdf) {
                            // Fetch the first page
                            var pageNumber = 1;
                            pdf.getPage(pageNumber).then(function (page) {
                                var scale = 1.5;
                                var viewport = page.getViewport({
                                    scale: scale,
                                });
                                // Prepare canvas using PDF page dimensions
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;
                                // Render PDF page into canvas context
                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport,
                                };
                                var renderTask = page.render(renderContext);
                                renderTask.promise.then(function () {});
                            });
                        },
                        function (reason) {
                            console.error(reason);
                        }
                    );
                };
                fileReader.readAsArrayBuffer(file);
            } else {
                $(this).val("");
                canvas.height = 0;
                canvas.width = 0;
                alert("Desculpe, o tamanho do arquivo ultrapassa 2MB");
            }
        } else if (validImageTypes.includes(file.type)) {
            var base_image = new Image();
            base_image.src = URL.createObjectURL(file);
            base_image.onload = function () {
                var context = canvas.getContext("2d");

                context.drawImage(base_image, 0, 0);
            };
        } else {
            $(this).val("");
            canvas.height = 0;
            canvas.width = 0;
            alert("Desculpe, o formato do arquivo deve ser .pdf");
        }
    });

    $(".btn-image").on("click", function () {
        $(this).next(".images").click();
    });

    $(".images").on("change", function () {
        var field = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return;

        if (/^image/.test(files[0].type)) {
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onloadend = function () {
                //Changed below line as well to show preview next to the changed element
                field.siblings(".preview-image").attr("src", this.result);
            };
        }
    });
})(jQuery);
window.utilities = {
    changeImage: function () {
        $("#image").click();
    },
    readUrl: function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = function (e) {
                $("#preview-image").attr("src", e.target.result);
                $("#remove-image").val(0);
            };
        }
    },
    removeImage: function () {
        $("#preview-image").attr("src", "/img/noimage.png");
        $("#remove-image").val(1);
    },
};

function getUrl() {
    return document.getElementById("baseurl").value;
}

function convertMoedaToFloat(value) {
    if (!value) {
        return 0;
    }

    var number_without_mask = value.replace(".", "").replace(",", ".");
    return parseFloat(number_without_mask.replace(/[^0-9\.]+/g, ""));
}

function convertFloatToMoeda(value) {
    return value.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

function activeMenu(url) {
    var element = $("ul.nav li a").filter(function () {
        return this.href == url.href || url.href.indexOf(this.href) == 0;
    });

    if (element.hasClass("collapse-item")) {
        element.addClass("active");
    }

    $(element)
        .parents()
        .each(function (index) {
            if (index == 0 && $(this).is("li")) {
                $(this).addClass("active");
            }
            if (this.className.indexOf("collapse") != -1) {
                $(this).addClass("show");
            }
        });
}

function loadPdf() {
    $("canvas").each(function (index) {
        var canvas = $(this)[0];
        var input = $(this).siblings('input[type="hidden"]')[0];
        if (input && input.value) {
            if (isImage(input.value)) {
                var base_image = new Image();
                base_image.src = input.value;
                base_image.onload = function () {
                    var context = canvas.getContext("2d");

                    context.drawImage(base_image, 0, 0);
                };
            } else {
                pdfjsLib
                    .getDocument({
                        url: input.value,
                    })
                    .promise.then(function (pdf) {
                        var context = canvas.getContext("2d");

                        pdf.getPage(1).then(function (page) {
                            var scale = 1.5;
                            var viewport = page.getViewport({
                                scale: scale,
                            });

                            // Prepare canvas using PDF page dimensions
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            // Render PDF page into canvas context
                            var renderContext = {
                                canvasContext: context,
                                viewport: viewport,
                            };
                            var renderTask = page.render(renderContext);
                        });
                    });
            }
        }
    });
}
function isImage(url) {
    return url.match(/\.(jpeg|jpg|gif|png|svg)$/) != null;
}
