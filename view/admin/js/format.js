function Format(){
    this.arr=[];
}

Format.prototype.htmlparser =  function (htmlstr) {

    let div,child
    div = document.createElement('div')
    div.innerHTML = htmlstr//.replace(/[\n]/g,'');
    child = div.childNodes

    this.nodeToHtml( child,0);
    return this.arr.join('')

};

Format.prototype.nodeToHtml=function(child,num,tagName='initial'){

    let tagArray=['br','input','img','hr','link','mate'];
    //console.log(child)



    for(let i=0;i<child.length;i++){

        if(child[i].nodeType==3){

            /*
            乘以 4 是因为 每次缩进四个空格，第一次替换后有回车节点空节点，或者空节点，
             比如 <span>123</span>   格式化之后就是
                <span>
                    123
                </span>
            如果我们编辑器查看源码格式经常切换，来回切换一次就是替换一次，
            这个时候如果不做处理进行第二次替换 就会变成
                <span>
                        123
                </span>
            又缩了四个空格，所以这里就是先把空格删除或者回车字符，记得要删除你要替换的空格数
            比如
                 <span>
                     123
                     <b>
                         456
                     </b>
                 </span>
            这个时候456前面是8个空格，那么你就要查找到8个空格字符带能删除，
            如果之后7个那就不能删除，因为只有7个的话说明是原本就有的，不是第一次添加的，

            这段规则适用于 当你的html字符串格式化之后在进行格式化不会乱套
            如果你这段html字符串 只需要格式一次的话那这个规则是不起作用的无需理会，

            其实几乎所有逻辑都是格式化一次然后显示在界面上，
            只是在富文本编辑器上，在源码模式要一边编辑一边显示来回切换，
            编辑完成需要进行第二次格式化，这个情况才会用到第二次
            */
            let reg = new RegExp('^([\n|\r|\r\n|↵][\\s]{'+(num*4)+'})|([\\s]{'+(num*4)+'})');
            let value= child[i].nodeValue.replace(reg,'');
            value=value.replace(/[\n|\r|\r\n|↵]/,'');   //替换开头或中间的回车字符

            //谨防回车节点或空文本节点，这些节点第一次是没有的，但是第一次格式化后就有了，所以造成第二次有了空行，这里过滤一下
            if(value.length!=0){
                this.insertIndent(num);
                this.arr.push(value);
                this.insertLine();
            }


        }else if(child[i].nodeType==1){
            let tagName =child[i].tagName.toLowerCase();
            let attrs = child[i].attributes
            let attrHtml = this.toAttrHtml( attrs );
            let ci = child[i].childNodes;
            if(tagArray.includes(tagName)){
                this.insertIndent(num);
                this.arr.push(`<${tagName}${attrHtml} />`)
            }else if(tagName=='pre'){

                //pre标签 另作处理
                this.insertIndent(num);
                this.arr.push(`<${tagName}${attrHtml}>`);
                this.insertLine();
                if(ci.length!=0){
                    this.arr.push(child[i].innerHTML.replace(/<br>/gm,'\n').replace(/&nbsp;/gm,' '));
                }
                this.insertIndent(num);
                this.insertLine();
                this.arr.push(`</${tagName}>`);
            }else {

               this.insertIndent(num);
               this.arr.push(`<${tagName}${attrHtml}>`);
               this.insertLine();

               if(ci.length!=0) this.nodeToHtml(ci,num+1,tagName);

               this.insertIndent(num);
               this.arr.push(`</${tagName}>`);

            }
            this.insertLine();
            this.insertIndent();
        }
    }

    //return html;
}

Format.prototype.toAttrHtml=function(attrs){
    let attrhtml = '';
    if(attrs.length>=1){
        attrhtml = [];
        for(let i=0;i<attrs.length;i++){
            attrhtml.push(attrs[i].name+'="'+attrs[i].nodeValue+'"');
        }
        attrhtml = ' '+attrhtml.join(' ');
    }
    return attrhtml;
}

Format.prototype.insertLine=function(){
    let breakChar = '\n';
    this.arr.push(breakChar)
}

Format.prototype.insertIndent=function(num){
    let indentChar = '    ';
    for(let i=0;i<num;i++){
        this.arr.push(indentChar);
    }

}