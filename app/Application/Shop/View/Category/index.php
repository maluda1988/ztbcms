<include file="Public/min-header" />
<div class="wrapper">
    <include file="Public/breadcrumb" />
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-1" style="display: inline-block;">
                                <button class="btn btn-default" type="button" onclick="tree_open(this);"><i class="fa fa-angle-double-down"></i>展开</button>
                            </div>
                            <div class="col-md-2 pull-right">
                                <a href="{:U('Category/addEditCategory')}" class="btn btn-primary "><i class="fa fa-plus"></i>新增分类</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="list-table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th valign="middle">分类ID</th>
                                            <th valign="middle">分类名称</th>
                                            <th valign="middle">手机显示名称</th>
                                            <th valign="middle">是否推荐</th>
                                            <th valign="middle">是否显示</th>
                                            <th valign="middle">分组</th>
                                            <th valign="middle">排序</th>
                                            <th valign="middle">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <foreach name="cat_list" item="vo" key="k">
                                            <tr role="row" align="center" class="{$vo.level}" id="{$vo.level}_{$vo.id}" <if condition="$vo[level] gt 1">style="display:none"</if>>
                                                <td>{$vo.id}</td>
                                                <td align="left" style="padding-left:<?php echo ($vo[level] * 5); ?>em">
                                                    <if condition="$vo.have_son eq 1">
                                                        <span class="glyphicon glyphicon-plus btn-warning" style="padding:2px; font-size:12px;" id="icon_{$vo.level}_{$vo.id}" aria-hidden="false" onclick="rowClicked(this)"></span>&nbsp;
                                                    </if>
                                                    <span>{$vo.name}</span>
                                                </td>
                                                <td><span>{$vo.mobile_name}</span></td>
                                                <td>
                                                    <img width="20" height="20" src="{$config_siteurl}statics/shop/images/<if condition='$vo[is_hot] eq 1'>yes.png<else />cancel.png</if>" onclick="changeTableVal('goods_category','id','{$vo.id}','is_hot',this)" />
                                                </td>
                                                <td>
                                                    <img width="20" height="20" src="{$config_siteurl}statics/shop/images/<if condition='$vo[is_show] eq 1'>yes.png<else />cancel.png</if>" onclick="changeTableVal('goods_category','id','{$vo.id}','is_show',this)" />
                                                </td>
                                                <td>
                                                    <input type="text" onchange="updateSort('goods_category','id','{$vo.id}','cat_group',this)" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" size="4" value="{$vo.cat_group}" class="input-sm" />
                                                </td>
                                                <td>
                                                    <input type="text" onchange="updateSort('goods_category','id','{$vo.id}','sort_order',this)" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" size="4" value="{$vo.sort_order}" class="input-sm" />
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="{:U('Category/addEditCategory',array('id'=>$vo['id']))}"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-danger" href="javascript:del_fun('{:U('Category/delGoodsCategory',array('id'=>$vo['id']))}');"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                        </foreach>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <!--<div class="dataTables_info" id="example1_info" role="status" aria-live="polite">分页</div>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    // 展开收缩
    function tree_open(obj) {
        var tree = $('#list-table tr[id^="2_"], #list-table tr[id^="3_"] '); //,'table-row'
        if (tree.css('display') == 'table-row') {
            $(obj).html("<i class='fa fa-angle-double-down'></i>展开");
            tree.css('display', 'none');
            $("span[id^='icon_']").removeClass('glyphicon-minus');
            $("span[id^='icon_']").addClass('glyphicon-plus');
        } else {
            $(obj).html("<i class='fa fa-angle-double-up'></i>收缩");
            tree.css('display', 'table-row');
            $("span[id^='icon_']").addClass('glyphicon-minus');
            $("span[id^='icon_']").removeClass('glyphicon-plus');
        }
    }

    // 以下是 bootstrap 自带的  js
    function rowClicked(obj) {
        span = obj;

        obj = obj.parentNode.parentNode;

        var tbl = document.getElementById("list-table");

        var lvl = parseInt(obj.className);

        var fnd = false;

        var sub_display = $(span).hasClass('glyphicon-minus') ? 'none' : '' ? 'block' : 'table-row';
        //console.log(sub_display);
        if (sub_display == 'none') {
            $(span).removeClass('glyphicon-minus btn-info');
            $(span).addClass('glyphicon-plus btn-warning');
        } else {
            $(span).removeClass('glyphicon-plus btn-info');
            $(span).addClass('glyphicon-minus btn-warning');
        }

        for (i = 0; i < tbl.rows.length; i++) {
            var row = tbl.rows[i];

            if (row == obj) {
                fnd = true;
            } else {
                if (fnd == true) {
                    var cur = parseInt(row.className);
                    var icon = 'icon_' + row.id;
                    if (cur > lvl) {
                        row.style.display = sub_display;
                        if (sub_display != 'none') {
                            var iconimg = document.getElementById(icon);
                            $(iconimg).removeClass('glyphicon-plus btn-info');
                            $(iconimg).addClass('glyphicon-minus btn-warning');
                        } else {
                            $(iconimg).removeClass('glyphicon-minus btn-info');
                            $(iconimg).addClass('glyphicon-plus btn-warning');
                        }
                    } else {
                        fnd = false;
                        break;
                    }
                }
            }
        }

        for (i = 0; i < obj.cells[0].childNodes.length; i++) {
            var imgObj = obj.cells[0].childNodes[i];
            if (imgObj.tagName == "IMG") {
                if ($(imgObj).hasClass('glyphicon-plus btn-info')) {
                    $(imgObj).removeClass('glyphicon-plus btn-info');
                    $(imgObj).addClass('glyphicon-minus btn-warning');
                } else {
                    $(imgObj).removeClass('glyphicon-minus btn-warning');
                    $(imgObj).addClass('glyphicon-plus btn-info');
                }
            }
        }

    }
</script>
</body>

</html>