$(document).ready(function(){
    $(function () {
        var jsonStructureObject = [{
           head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_05.jpg" alt=""></div><div class="top_title">CEO</div><div class="section_num">1</div>',
           id: 'ceo',
           contents: '<ul class="content-container"><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_05.jpg"></div><div class="member_name">Joanne社長</div></li></ul>',
           children: [
               {
                   head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_01.jpg" alt=""></div><div class="top_title">DAO1</div><div class="section_num">1</div>',
                   id: 'dao1',
                   contents: '<ul class="content-container"><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_01.jpg"></div><div class="member_name">Hide</div></li></ul>',
                   children: [
                       {
                            head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_02.jpg" alt=""></div><div class="top_title">Sub DAO1</div><div class="section_num">225</div>',
                            id: 'subdao1',
                            contents: '<ul class="content-container"><li class="combination"><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_03.jpg"></div><div class="member_name">Name01</div></li><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_04.jpg"></div><div class="member_name">Name02</div></li><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_06.jpg"></div><div class="member_name">Name03</div></li><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_07.jpg"></div><div class="member_name">Name04</div></li><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_08.jpg"></div><div class="member_name">Name05</div></li><li class="absence"><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_14.jpg"></div><div class="member_name">Name06</div></li></ul>'
                        }
                   ]
               },
               {
                   head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_09.jpg" alt=""></div><div class="top_title">DAO2</div><div class="section_num">1</div>',
                   id: 'dao2',
                   contents: '<ul class="content-container"><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_09.jpg"></div><div class="member_name">Sam</div></li></ul>',
                   children: [
                       {
                            head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_10.jpg" alt=""></div><div class="top_title">Sub DAO2</div><div class="section_num">1</div>',
                            id: 'subdao2',
                            contents: '<ul class="content-container"><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_10.jpg"></div><div class="member_name">James</div></li></ul>'
                        },
                   ]
               },
               {
                   head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_11.jpg" alt=""></div><div class="top_title">DAO3</div><div class="section_num">1</div>',
                   id: 'dao3',
                   contents: '<ul class="content-container"><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_11.jpg"></div><div class="member_name">Tokky</div></li></ul>',
                   children: [
                       {
                            head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_12.jpg" alt=""></div><div class="top_title">Sub DAO3</div><div class="section_num">1</div>',
                            id: 'subdao3',
                            contents: '<ul class="content-container"><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_12.jpg"></div><div class="member_name">Kenneth</div></li></ul>'
                        },
                        {
                            head: '<div class="top_img"><img class="top-thumb" src="/imgs/staff_13.jpg" alt=""></div><div class="top_title">Sub DAO4</div><div class="section_num">1</div>',
                            id: 'subdao4',
                            contents: '<ul class="content-container"><li><div class="member_photo"><img class="staff_thumb" src="/imgs/staff_13.jpg"></div><div class="member_name">Angge</div></li></ul>'
                        },
                   ]
               }
               
           ]
        }];
        $("#tree").jHTree({
           callType: 'obj',
           structureObj: jsonStructureObject,
           zoomer: false,
        });
    });

    $("div.content-container").draggable({
    });
    
    // /*↓↓↓↓↓↓↓ Drag n Drop Functions for Staff Position Setting ↓↓↓↓↓↓↓*/
    // function allowDrop(ev)
    // {
    //     ev.preventDefault();
    // }
    
    // function drag(ev)
    // {
    //     ev.preventDefault();
    //     // ev.dataTransfer.setData("from_id", ev.target.id);
    //     console.log(ev);
    // }
    
    // function drop(ev)
    // {
    //     ev.preventDefault();
    //     var $from_data_id = ev.dataTransfer.getData("from_id");
    //     var $to_data_id = ev.toElement.id;
        
    //     process_data($from_data_id, $to_data_id);
    // }
    // /*↑↑↑↑↑↑↑ Drag n Drop Functions for Staff Position Setting ↑↑↑↑↑↑↑*/
    $(function () {
        var $AcMenuOpen = $('.ac_menu');
    
        $AcMenuOpen.on('click',function(){
            if ($(this).hasClass('is-open')){
                $(this).removeClass('is-open');
                $(this).parent().removeClass('tr-open');
            } else {
                $(this).addClass('is-open');
                $(this).parent().addClass('tr-open');
            }
        });
    
    });
});

