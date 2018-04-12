/* 
 * @author  Vincent
 * @version CI3
 */
var save_method;
var region_table;
var group_parent_finder;
var group_finder;
var region_finder;

var url = window.location;
var module = location.href.substr(location.href.lastIndexOf('/') + 1);
var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1] + "/";

$(document).ready(function() {
    
    $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
    } ).parent().addClass('active');
    
    $('ul.treeview-menu a').filter(function() {
        return this.href == url;
    } ).parentsUntil('.sidebar-menu > .treeview-menu').addClass('active');

    $("input").change(function() {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    } );
    $("textarea").change(function() {
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    } );
    $("select").change(function() {
        $(this).parent().parent().parent().parent().removeClass('has-error');
        $(this).parent().parent().next().empty();
    } );
    
    $('#group-parent-modal, #group-modal, #region-modal').on('show.bs.modal', function () {
        $(this).find('.modal-dialog').css( {width:'80%', height:'auto', 'max-height':'100%'} );
    } );
    
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    } );
    
    estate_table = $('#estate-table').DataTable( {
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "columnDefs" : [ 
        { 
            "targets" : [ 0, 7 ],
            "visible" : false,
            "orderable" : false
        },
        { 
            "targets" : [ -1 ],
            "orderable" : false
        } ],
        "ajax" : {
            url : base_url + "estate/estate_list/vsp",
            type : "POST"
        }
    } );
    
    // GROUP PARENT FINDER
    group_parent_finder = $('#group-parent-table').DataTable( {
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "columnDefs" : [],
        "ajax" : {
          url : base_url + "group_parent/group_parent_list/vsc",
          type : "POST"
        }
    } );
    
    $('#group-parent-table tbody').on('click', 'tr', function() {
        var group_parent_data = group_parent_finder.row( this ).data();
        if ( group_parent_data[0] != null && group_parent_data[1] != null ) {
            $('[name="group_parent_code"]').val( group_parent_data[0] );
            $('[name="group_parent"]').val( group_parent_data[1] );

            $('#group-parent-modal').modal( 'hide' );
            $('[name="group_parent"]').parent().parent().parent().removeClass('has-error');
            $('[name="group_parent"]').parent().next().empty();
            $('#group').val('');
            $('#region').val('');
            populate_group_data( $('[name="group_parent_code"]').val() );
        } else {
            swal( 'Data is not available.', {
                icon: 'error'
            } );
        }
    } );
    // END GROUP PARENT FINDER
    
    // GROUP FINDER
    $('#group-table tbody').on( 'click', 'tr', function() {
        var group_data = group_finder.row( this ).data();
        if ( group_data[0] != null && group_data[1] != null ) {
            $('[name="group_code"]').val( group_data[0] );
            $('[name="group"]').val( group_data[1] );

            $('#group-modal').modal( 'hide' );
            $('[name="group"]').parent().parent().parent().removeClass('has-error');
            $('[name="group"]').parent().next().empty();
            $('#region').val('');
            populate_region_data( $('[name="group_code"]').val() );
        } else {
            swal( 'Data is not available.', {
                icon: 'error'
            } );
        }
    } );
    // END GROUP FINDER
    
    // REGION FINDER
    $('#region-table tbody').on( 'click', 'tr', function() {
        var region_data = region_finder.row( this ).data();
        if ( region_data[0] != null && region_data[1] != null ) {
            $('[name="region_code"]').val( region_data[0] );
            $('[name="region"]').val( region_data[1] );

            $('#region-modal').modal( 'hide' );
            $('[name="region"]').parent().parent().parent().removeClass('has-error');
            $('[name="region"]').parent().next().empty();
        } else {
            swal( 'Data is not available.', {
                icon: 'error'
            } );
        }
    } );
    // END REGION FINDER
    $('[name="type"]').selectpicker();
});

function populate_group_data( parent_code = '' )
{
    group_finder = $('#group-table').DataTable( { 
        'responsive' : true,
        'processing' : true,
        'serverSide' : true,
        'destroy' : true,
        'order' : [],
        'columnDefs' : [],
        'ajax' : {
            url : base_url + 'group/group_list/vsc/' + parent_code,
            type : 'POST'
        }
    } );    
}

function populate_region_data( group_code = '' )
{   
    region_finder = $('#region-table').DataTable( { 
        'responsive' : true,
        'processing' : true,
        'serverSide' : true,
        'destroy' : true,
        'order' : [],
        'columnDefs' : [],
        'ajax' : {
            url : base_url + 'region/region_list/vsc/' + group_code,
            type : 'POST'
        }
    } );    
}

function reload_table()
{
    estate_table.ajax.reload( null, true );
}

function reset_form()
{
    $('#estate-form')[0].reset();
    $('.form-group').removeClass( 'has-error' );
    $('.help-block').empty();
    $('[name="estate_short_name"]').prop( 'readOnly', false );
    $('[name="type"]').val( '' );
    $('[name="type"]').selectpicker( 'refresh' );
}

function send_action( type, id )
{
    id = id || undefined;
    
    if ( module == 'estate' ) {
        
        if ( type == 'add' ) {
            
            save_method = 'add';
            reset_form();
            $('#estate-modal').modal( 'show' ); 
            $('#estate-modal-label').text( 'Add Estate' );
            
        } else if ( type == 'edit' ) {
            
            save_method = 'update';
            reset_form();
            $.ajax( {
                url : base_url + 'estate/estate_edit/' + id,
                type : 'GET',
                dataType : 'JSON',
                success : function( data ) {
//                    console.log(data);
                    $('[name="estate_code"]').val( data.estate_code );
                    $('[name="estate_short_name"]').prop( 'readOnly', true );
                    $('[name="estate_short_name"]').val( data.estate_short_name );
                    $('[name="estate_name"]').val( data.estate_name );
                    $('[name="description"]').val( data.description );
                    $('[name="type"]').val( data.type );
                    $('[name="type"]').selectpicker( 'refresh' );
                    $('[name="group_parent_code"]').val( data.group_parent_code );
                    $('[name="group_parent"]').val( data.group_parent_name );
                    $('[name="group_code"]').val( data.group_code );
                    $('[name="group"]').val( data.group_name );
                    $('[name="region_code"]').val( data.region_code );
                    $('[name="region"]').val( data.region_name );
                    populate_group_data( data.group_parent_code );
                    populate_region_data( data.group_code );
                    $('#estate-modal').modal( 'show' ); 
                    $('#estate-modal-label').text( 'Edit Estate' );
                },
                error : function ( jqXHR, textStatus, errorThrown ) {
                    swal( 'Failed to load data.', {
                        icon: 'error'
                    } );
                }
            } );
            
        } else if ( type == 'save' ) {
            
            var url;
            if ( save_method == 'add' ) {
                url = base_url + 'estate/estate_add';
                title = 'Are you sure to save this data?';
            } else {
                url = base_url + 'estate/estate_update';
                title = 'Are you sure to save this data?';
            }
            swal( {
                title: title,
                buttons: true,
                dangerMode: false
            } )
            .then( function (willSave) {
                if (willSave) {
                    $('#btn-save').text( 'Saving...' );
                    $('#btn-save').prop( 'disabled', true );
                    var form = $('#estate-form');
                    $.ajax({
                        url : url,
                        type : 'POST',
                        data : form.serialize(),
                        dataType : 'JSON',
                        success : function( data ) {
                            if ( data.status ) {
                                $('#estate-modal').modal( 'hide' );
                                reload_table();
                                swal('Data has been saved!', {
                                    icon: 'success'
                                } );
                            } else {
                                $.each(data.errors, function(key, value) {              
                                    if ( $('[name="'+ key +'"]', form).parent().parent().is('.selectContainer') ) {
                                        $('[name="'+ key +'"]', form).parent().parent().parent().parent().addClass('has-error');
                                        $('[name="'+ key +'"]', form).parent().parent().next().text(value);
                                    } else if ( $('[name="'+ key +'"]', form).parent().is('.input-group') ) {
                                        $('[name="'+ key +'"]', form).parent().parent().parent().addClass('has-error');
                                        $('[name="'+ key +'"]', form).parent().next().text(value);
                                    } else {
                                        $('[name="'+ key +'"]', form).parent().parent().addClass('has-error');
                                        $('[name="'+ key +'"]', form).next().text(value);
                                    }
                                } );
                            }
                            $('#btn-save').text( 'Save' );
                            $('#btn-save').prop( 'disabled', false ); 
                        },
                        error : function ( jqXHR, textStatus, errorThrown ) {
                            swal( 'Failed to save data.', {
                                icon: 'error'
                            } );
                            $('#btn-save').text( 'Save' );
                            $('#btn-save').prop( 'disabled', false );
                        }
                    } );
                }
            } );
            
        } else if ( type == 'delete' ) {
            
            swal( {
                title: "Are you sure to delete this data?",
                buttons: true,
                dangerMode: true
            } )
            .then( function (willDelete) {
                if (willDelete) {
                    $.ajax( {
                        url : base_url + 'estate/estate_delete/' + id,
                        type : 'POST',
                        dataType : 'JSON',
                        success : function( data ) {
                            $('#estate-modal').modal( 'hide' );
                            reload_table();
                            
                            swal('Data has been deleted!', {
                                icon: 'success'
                            } );
                        },
                        error : function ( jqXHR, textStatus, errorThrown ) {
                            swal( 'Failed to delete data.', {
                                icon: 'error'
                            } );
                        }
                    } );
                }
            } );
            
        }
    }
}