<script type="text/javascript">
 function routeChart(pair,techn,myassgin,assignDate,next_available_arr,next_available_cond,last_update_arr,noJobs,phone,median,newtech,rowcounticon){
                                               //pairAddress = array();
                                               // console.log('Custom Pair '+pair);
                                                var pairAddress        = [[],[]];
                                               // var partTimeVar = '';
                                               // var partTimeVar1 = '';
                                              $.each(pair,function(k,v){
                                                //console.log('paaai',v.address);
                                                if(pairAddress[0].length < 25 ){
                                                  pairAddress[0].push(v.address);
                                                } else if(pairAddress[1].length < 25 ){
                                                  pairAddress[1].push(v.address);
                                                }

                                               })

                                              //console.log('pairaddress kaka lalal 0 ',pairAddress[0]);
                                              //console.log('pairaddress kaka lalal 1 ',pairAddress[1]);
                                                         var geocoder = new google.maps.Geocoder;
                                                             var service = new google.maps.DistanceMatrixService;                   
                                                             var jobJsArr = [];  
                                                             var jobJsArr = '<?php echo $custArr_time; ?>'; 
                                                           
                                                             service.getDistanceMatrix({
                                             
                                                              origins: pairAddress[0],
                                                              destinations: [jobJsArr],
                                                              travelMode: 'DRIVING',
                                                              drivingOptions: {
                                                                departureTime: new Date(),
                                                                trafficModel: 'bestguess',
                                                              },
                                                               // departureTime: new Date(Date.now()),  // for the time N milliseconds from now.                    
                                                              unitSystem: google.maps.UnitSystem.IMPERIAL,
                                                              avoidHighways: false,
                                                              avoidTolls: false
                                                          }, function(response, status) {
                                                           //console.log('status',status);
                                                              var ress    = JSON.stringify(response);
                                                //console.log('ressss',ress);
                                                var ress    = JSON.parse(ress);
                                             
                                                //console.log(ress);   
                                                var  fres   = '';
                                                
                                                var fhtml = '';    
                                                var count = 0;
                                                $.each( ress.rows, function( resKey, resVal ) {
                                                 //console.log(resKey);
                                             
                                                 if(count == 10){
                                                   //delay('1000');
                                                   wait(1000);
                                                                         count = 0;
                                                 }
                                                   $.each(techn,function(k,v){
                                             
                                                     if(resKey==k){
                                             
                                                       ress.rows[resKey].elements[0].techname=v;
                                             
                                                     }
                                             
                                                   })
                                             
                                             
                                                   $.each(assignDate,function(k1,v1){
                                             
                                                     if(resKey==k1){
                                                      //console.log('dateee',v1);
                                             
                                                       ress.rows[resKey].elements[0].assig_date=v1;
                                             
                                                     }
                                             
                                                   })
                                             
                                                   $.each(next_available_arr,function(k2,v2){
                                             
                                                     if(resKey==k2){
                                             
                                                       ress.rows[resKey].elements[0].next_date=v2;
                                             
                                                     }
                                             
                                                   })

                                             
                                                   
                                                   $.each(last_update_arr,function(k3,v3){
                                             
                                                     if(resKey==k3){
                                             
                                                       ress.rows[resKey].elements[0].last_update=v3;
                                             
                                                     }
                                             
                                                   })
                                             
                                             
                                                   $.each(noJobs,function(k4,v4){
                                             
                                                     if(resKey==k4){
                                             
                                                       ress.rows[resKey].elements[0].no_jobss=v4;
                                             
                                                     }
                                             
                                                   })
                                             
                                             //console.log('assigend',asgJobId_arr);
                                                   $.each(myassgin,function(k5,v5){
                                             
                                                     if(resKey==k5){
                                             
                                                       ress.rows[resKey].elements[0].asgId_arr=v5;
                                             
                                                     }
                                             
                                                   })

                                                    $.each(phone,function(k6,v6){
                                             
                                                     if(resKey==k6){
                                             
                                                       ress.rows[resKey].elements[0].phone=v6;
                                             
                                                     }
                                             
                                                   })


                                                    $.each(median,function(k7,v7){
                                             
                                                     if(resKey==k7){
                                             
                                                       ress.rows[resKey].elements[0].median=v7;
                                             
                                                     }
                                             
                                                   })

                                                    $.each(newtech,function(k8,v8){
                                             
                                                     if(resKey==k8){
                                             
                                                       ress.rows[resKey].elements[0].newtech=v8;
                                             
                                                     }
                                             
                                                   })

                                                   
                                                    $.each(next_available_cond,function(k9,v9){
                                             
                                                     if(resKey==k9){
                                             
                                                       ress.rows[resKey].elements[0].next_date1=v9;
                                             
                                                     }
                                             
                                                   })

                                                   $.each(rowcounticon,function(k10,v10){
                                             
                                                     if(resKey==k10){
                                             
                                                       ress.rows[resKey].elements[0].rowcounticon=v10;
                                             
                                                     }
                                             
                                                   }) 
                                             
                                                 lastRes = ress.rows[resKey].elements[0];
                                                 //console.log('valluu',lastRes.techname);
                                                 //console.log('duration',lastRes.duration_in_traffic);
                                                 
                                                 destinationArr = ress.destinationAddresses[0];
                                                 originArr = ress.originAddresses[resKey];
                                                 //console.log('lenfthhh',originArr.length);
                                             
                                                 if(lastRes.status!='ZERO_RESULTS'){
                                                     
                                                     var minuteValue = lastRes.duration_in_traffic.value
                                                     var minutes = Math.floor(minuteValue / 60);
                                                                 
                                                                 var SingleDigit = minutes.toString().length;
                                                                 if(SingleDigit == 1){
                                                                   minutes1 = '000'+minutes;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(SingleDigit == 2){
                                                                   minutes1 = '00'+minutes;
                                                                 }else if(SingleDigit == 3){
                                                                   minutes1 = '0'+minutes;
                                                                 }else{
                                                                  minutes1 = minutes;
                                                                 }
                                                                
                                             
                                                      var redindicator = $.trim(lastRes.no_jobss);          
                                                                 console.log(lastRes.techname);
                                                                 //$(".backColor").css("background", (lastRes.techname !== 'Cuby') ? "green" : "orange");
                                             
                                                     var html    = '';
                                                     var html1    = '';
                                                     var html2    = '';
                                                     var html3    = '';
                                                     var respAssign = '';
                                                     var respAssign = lastRes.assig_date;


                                                     //console.log('faltu',respAssign);
                                                     if(respAssign == null){
                                                      respAssign  = '';
                                                     }else{
                                                      respAssign  = lastRes.assig_date;
                                                     }

                                                      var altmeg = lastRes.phone;
                                                      var d = new Date();
                                                      var amm = (d.getHours() < 12) ? "AM" : "PM";
                                                      var hourss = '';
                                                      var strDate = '';
                                                      var strDateComp = '';
                                                      var hourss = d.getHours() % 12 || 12;
                                                      var strDate = (d.getMonth()+1) + "/" + d.getDate() +" "+ hourss +":"+ d.getMinutes() +" "+amm;
                                                      var strDateComp = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate() +" "+ hourss +":"+ d.getMinutes() +" "+amm;
                                                      //console.log('nnnnexttt',lastRes.next_date1);
                                                      //console.log('cuurrnnt',strDateComp);

                                                      //var strDate = (d.getMonth()+1) + "/" + d.getDate() +" "+ hourss +":"+ d.getMinutes() +" "+amm;
                                                       var bgcolorr = '';
                                                                 if(minutes1 > 45){
                                                                  var bgcolorr = '#FF0000';
                                                                  //var bgcolorr1 = '#FF0000';
                                                                  if(new Date(lastRes.next_date1) > new Date(strDateComp)) {var bgcolorr1 = '#E8B44B';}else{var bgcolorr = '#FF0000';bgcolorr1 = '#FFFF';} 
                                                                 }else{
                                                                  if(new Date(lastRes.next_date1) > new Date(strDateComp)) {var bgcolorr1 = '#E8B44B';}else{var bgcolorr = '#FFFF';bgcolorr1 = '#FFFF';} 
                                                                 }
                                                     if(lastRes.newtech == '1' && lastRes.rowcounticon <= 10 && minutes <= 45){
                                                       var median1 = '';
                                                                 var mediandigit = '';
                                                                 var firstcase = '';
                                                                 var firstcase = '#FCE684';
                                                                 //var arrDecimal = lastRes.median.toString().split('.');
                                                                 var mediandigit = lastRes.median.toString().length;
                                                                 //console.log(mediandigit);
                                                                 if(mediandigit == 0){
                                                                   median1 = '200000'+lastRes.median;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(mediandigit == 1){
                                                                   median1 = '20000'+lastRes.median;
                                                                 }else if(mediandigit == 2){
                                                                   median1 = '2000'+lastRes.median;
                                                                 }else if(mediandigit == 3){
                                                                   median1 = '200'+lastRes.median;
                                                                 }else if(mediandigit == 4){
                                                                  median1 = '20'+lastRes.median;
                                                                 }else if(mediandigit == 5){
                                                                  median1 = '2'+lastRes.median;
                                                                 }

                                                       html += "<tr>";
                                                       if(bgcolorr == '#FFFF'){
                                                        html += "<td style='background-color:"+firstcase+"'>";
                                                       }else{
                                                        html += "<td style='background-color:"+bgcolorr+"'>";
                                                       }
                                                       html += "<span style='display:none'>"+median1+"</span>"+lastRes.duration_in_traffic.text+"<a href='https://www.google.co.in/maps/dir/"+originArr+"/"+destinationArr+"' target='_blank'><img src='shedulesheet/map_icon.png' height='20' width='20' id='icon_map_"+resKey+"' alt='#' target='_blank'></a>"
                                                       html += "</td>";
                                                     html += "<td style='background-color:"+firstcase+"'><span id='myroute"+resKey+"' class='mycharticon'>"+lastRes.techname+"</span>";
                                                     if(lastRes.newtech == '1'){
                                                     html += "<span class='newhire'>New Hire!</span><span class='newhire'>"+lastRes.rowcounticon+" Completed Job(s)</span>";
                                                     }                                                      
                                                     html += "</p>";
                                                     html += "</td>";
                                                     html += "<td style='background-color:"+firstcase+"'>";
                                                     html += "<span style='color:blue'>"+lastRes.asgId_arr+' '+"</span>"; 
                                                     html += "<span>"+respAssign+"</span>";
                                                     html += "</td>";
                                                     if(bgcolorr1 == '#FFFF'){
                                                        html += "<td style='background-color:"+firstcase+"'>";
                                                       }else{
                                                        html += "<td style='background-color:"+bgcolorr1+"'>";
                                                       }
                                                     html += "<div class='dateshow'>"; 
                                                     html += "<span id='nexttimesD"+resKey+"'>"+lastRes.next_date+"</span>";
                                                     html += "<span id='nexttimes"+resKey+"'></span>";
                                                     html += "<div class='iconshow'>";
                                                     html += "<i class='fas fa-sync-alt' id='nextpop"+resKey+"' aria-hidden='true'></i>";
                                                     html += "<div class='tblshow nexttblshow' id='nexttbl"+resKey+"' style='display:none'>";
                                                     html += "<table>";
                                                     html += "<tr><td width='100'>Date</td><td><input type='hidden' id='technme"+resKey+"' value='"+lastRes.techname+"'><input type='date' id='datepicker"+resKey+"'></td></tr>";                                                  
                                                     html += "<tr><td>Time</td><td><div class='timetbl'><input type='text' id='time1"+resKey+"' style='max-width: 32px;'><input type='text' id='time2"+resKey+"' style='max-width: 32px;'><select id='ampm"+resKey+"' name='' style='max-width: 44px;'><option value='AM'>AM</option><option value='PM'>PM</option></select></div></td></tr>";
                                                     html += "<tr><td>Contact Failed</td><td><input type='checkbox' id='Cfailed"+resKey+"'></td></tr>";
                                                     html += "<tr><td>Notes</td><td><textarea id='notes"+resKey+"'></textarea></td></tr>";                                                  
                                                     html += "<tr><td  colspan='2' align='right'><input type='button' id='btnNext"+resKey+"' value='submit' class='btn btn-primary'></td></tr>";                                                  
                                                     html += "</table>";
                                                     html += "</div>";
                                                     html += "</div>";
                                                     html += "</div>";
                                                     html += "</td>";
                                                     html += "<td style='background-color:"+firstcase+"'>";
                                                     html += "<div class='histlast'><span id='lastupp"+resKey+"'></span>";
                                                     html += "<span id='lastupD"+resKey+"'>"+lastRes.last_update+"</span>";
                                                     html += "<div class='histNotes'>";
                                                     html += "<i class='fas fa-file-alt' id='lastup"+resKey+"' aria-hidden='true'></i>";

                                                  var techhname = lastRes.techname;
                                                  $.ajax({
                                                              url: "getnexthistory.php",
                                                              type: 'POST',
                                                              dataType : "json",                                                              
                                                              cache: false,
                                                              data: {tchname : techhname},
                                                              success: function(data){
                                                                console.log(data);
                                                  
                                                                var len = data.length;
                                                                //console.log('legnth',len);
                                                                html += "<table class='tblpop'>";
                                                                html += "<tr>";
                                                                html += "<td><b>Office User</b></td>";
                                                                html += "<td><b>Update Date</b></td>";
                                                                html += "<td><b>Availability Entered</b></td>";
                                                                html += "<td><b>Notes</b></td>";
                                                                html += "</tr>";
                                                                for (var i=0; i<len; i++) {
                                                                  var user = data[i].user;
                                                                  //console.log('userrr',user);
                                                                  var failed = data[i].failed;
                                                                  var last_update = data[i].last_update;
                                                                  var next_available = data[i].next_available;
                                                                  var notes = data[i].notes;
                                                                 html += "<tr><td>"+user+"</td><td>"+last_update+"</td><td>"+next_available+"</td><td>"+notes+"</td></tr>";
                                                                }
                                                                html += "</table>";
                                                                $("#ShowTable1"+resKey).append(html);

                                                                                                                                          
                                                              }

                                                            });

                                                     html += "<div id='ShowTable1"+resKey+"' class='tblshow1' style='display:none'></div>";
                                                     html += "</div>";
                                                     html += "</div>";
                                                     html += "</td>";
                                                     html += "</tr>";

                                                      $("#ShowTable").append(html);

                                                      //$("#ShowTable").append(html1);
                                                      setTimeout(function(){ 
                                                 $("#table_sorting").tablesorter({
                          

                                                                    // sort on the third column, order asc
                                                       sortList: [[0,1]]
                                                 });
                                             }, 4000);

                                                      
                                                     }else if((lastRes.newtech == '1' && minutes > 45) || (lastRes.newtech == '0' && minutes > 45)){
                                                       var distancethree = '';
                                                      var mintlength = minutes.toString().length;
                                                      var firstcase1 = '';
                                                      var firstcase1 = '#FF8187';

                                                       if(mintlength == 1){
                                                                   distancethree = '1111'+minutes;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(SingleDigit == 2){
                                                                   distancethree = '111'+minutes;
                                                                 }else if(SingleDigit == 3){
                                                                   distancethree = '11'+minutes;
                                                                 }else if(SingleDigit == 4){
                                                                   distancethree = '1'+minutes;
                                                                 }else{
                                                                  distancethree = minutes;
                                                                 }

                                                                 var mediandigit1 = '';
                                                                 var medians ='';
                                                                 var mediandigit1 = lastRes.median.toString().length;
                                                                 console.log(mediandigit1);
                                                                 if(mediandigit1 == 0){
                                                                   medians = '000000'+lastRes.median;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(mediandigit1 == 1){
                                                                   medians = '00000'+lastRes.median;
                                                                 }else if(mediandigit1 == 2){
                                                                   medians = '0000'+lastRes.median;
                                                                 }else if(mediandigit1 == 3){
                                                                   medians = '000'+lastRes.median;
                                                                 }else if(mediandigit1 == 4){
                                                                   medians = '00'+lastRes.median;
                                                                 }else if(mediandigit1 == 5){
                                                                   medians = '0'+lastRes.median;
                                                                 }



                                                      //console.log('lengg',mintlength);
                                                      /*if(mintlength == '2'){
                                                        var distancethree  = minutes;
                                                      }else{
                                                        var distancethree = lastRes.duration_in_traffic.text; 
                                                      }*/
                                                                
                                                       html1 += "<tr>";
                                                       if(bgcolorr == '#FFFF'){
                                                        html1 += "<td style='background-color:"+firstcase1+"'>";
                                                       }else{
                                                        html1 += "<td style='background-color:"+bgcolorr+"'>";
                                                       }
                                                       html1 += "<span style='display:none'>"+medians+"</span>"+lastRes.duration_in_traffic.text+"<a href='https://www.google.co.in/maps/dir/"+originArr+"/"+destinationArr+"' target='_blank'><img src='shedulesheet/map_icon.png' height='20' width='20' id='icon_map_"+resKey+"' alt='#' target='_blank'></a>"
                                                       html1 += "</td>";
                                                     html1 += "<td style='background-color:"+firstcase1+"'><span></span><span id='myroute"+resKey+"' class='mycharticon'>"+lastRes.techname+"</span>";
                                                     if(lastRes.newtech == '1'){
                                                     html1 += "<span class='newhire'>New Hire!</span><span class='newhire'>"+lastRes.rowcounticon+" Completed Job(s)</span>";
                                                     }                                                      
                                                     html1 += "</p>";
                                                     html1 += "</td>";
                                                     html1 += "<td style='background-color:"+firstcase1+"'>";
                                                     html1 += "<span style='color:blue'>"+lastRes.asgId_arr+' '+"</span>"; 
                                                     html1 += "<span>"+respAssign+"</span>";
                                                     html1 += "</td>";
                                                     if(bgcolorr1 == '#FFFF'){
                                                      html1 += "<td style='background-color:"+firstcase1+"'>";
                                                     }else{
                                                      html1 += "<td style='background-color:"+bgcolorr1+"'>";
                                                     }
                                                     html1 += "<div class='dateshow'>"; 
                                                     html1 += "<span id='nexttimesD"+resKey+"'>"+lastRes.next_date+"</span>";
                                                     html1 += "<span id='nexttimes"+resKey+"'></span>";
                                                     html1 += "<div class='iconshow'>";
                                                     html1 += "<i class='fas fa-sync-alt' id='nextpop"+resKey+"' aria-hidden='true'></i>";
                                                     html1 += "<div class='tblshow nexttblshow' id='nexttbl"+resKey+"' style='display:none'>";
                                                     html1 += "<table>";
                                                     html1 += "<tr><td width='100'>Date</td><td><input type='hidden' id='technme"+resKey+"' value='"+lastRes.techname+"'><input type='date' id='datepicker"+resKey+"'></td></tr>";                                                  
                                                     html1 += "<tr><td>Time</td><td><div class='timetbl'><input type='text' id='time1"+resKey+"' style='max-width: 32px;'><input type='text' id='time2"+resKey+"' style='max-width: 32px;'><select id='ampm"+resKey+"' name='' style='max-width: 44px;'><option value='AM'>AM</option><option value='PM'>PM</option></select></div></td></tr>";
                                                     html1 += "<tr><td>Contact Failed</td><td><input type='checkbox' id='Cfailed"+resKey+"'></td></tr>";
                                                     html1 += "<tr><td>Notes</td><td><textarea id='notes"+resKey+"'></textarea></td></tr>";                                                  
                                                     html1 += "<tr><td  colspan='2' align='right'><input type='button' id='btnNext"+resKey+"' value='submit' class='btn btn-primary'></td></tr>";                                                  
                                                     html1 += "</table>";
                                                     html1 += "</div>";
                                                     html1 += "</div>";
                                                     html1 += "</div>";
                                                     html1 += "</td>";
                                                     html1 += "<td style='background-color:"+firstcase1+"'>";
                                                     html1 += "<div class='histlast'><span id='lastupp"+resKey+"'></span>";
                                                     html1 += "<span id='lastupD"+resKey+"'>"+lastRes.last_update+"</span>";
                                                     html1 += "<div class='histNotes'>";
                                                     html1 += "<i class='fas fa-file-alt' id='lastup"+resKey+"' aria-hidden='true'></i>";

                                                  var techhname = lastRes.techname;
                                                  $.ajax({
                                                              url: "getnexthistory.php",
                                                              type: 'POST',
                                                              dataType : "json",                                                              
                                                              cache: false,
                                                              data: {tchname : techhname},
                                                              success: function(data){
                                                                console.log(data);
                                                  
                                                                var len = data.length;
                                                                //console.log('legnth',len);
                                                                html1 += "<table class='tblpop'>";
                                                                html1 += "<tr>";
                                                                html1 += "<td><b>Office User</b></td>";
                                                                html1 += "<td><b>Update Date</b></td>";
                                                                html1+= "<td><b>Availability Entered</b></td>";
                                                                html1 += "<td><b>Notes</b></td>";
                                                                html1 += "</tr>";
                                                                for (var i=0; i<len; i++) {
                                                                  var user = data[i].user;
                                                                  //console.log('userrr',user);
                                                                  var failed = data[i].failed;
                                                                  var last_update = data[i].last_update;
                                                                  var next_available = data[i].next_available;
                                                                  var notes = data[i].notes;
                                                                 html1 += "<tr><td>"+user+"</td><td>"+last_update+"</td><td>"+next_available+"</td><td>"+notes+"</td></tr>";
                                                                }
                                                                html1 += "</table>";
                                                                $("#ShowTable1"+resKey).append(html1);

                                                                                                                                          
                                                              }

                                                            });

                                                     html1 += "<div id='ShowTable1"+resKey+"' class='tblshow1' style='display:none'></div>";
                                                     html1 += "</div>";
                                                     html1 += "</div>";
                                                     html1 += "</td>";
                                                     html1 += "</tr>";

                                                     $("#ShowTable").append(html1);

                                                     setTimeout(function(){ 
                                                 $("#table_sorting").tablesorter({
                          

                                                                    // sort on the third column, order asc
                                                       sortList: [[0,1]]
                                                 });
                                             }, 4000);

                                                     }else if((lastRes.newtech == '1' && minutes <= 45 && lastRes.rowcounticon >= 11) || (lastRes.newtech == '0' && minutes <= 45)){
                                                      var firstcase2 = '';
                                                      var firstcase2 = '#FFFF';

                                                      var distancethree = '';
                                                      var mintlength = minutes.toString().length;

                                                       if(mintlength == 1){
                                                                   distancethree = '1111'+minutes;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(SingleDigit == 2){
                                                                   distancethree = '111'+minutes;
                                                                 }else if(SingleDigit == 3){
                                                                   distancethree = '11'+minutes;
                                                                 }else if(SingleDigit == 4){
                                                                   distancethree = '1'+minutes;
                                                                 }else{
                                                                  distancethree = minutes;
                                                                 }

                                                                 var mediandigit2 = '';
                                                                 var medians1 ='';
                                                                 var mediandigit2 = lastRes.median.toString().length;
                                                                 //console.log(mediandigit1);
                                                                 if(mediandigit2 == 0){
                                                                   medians1 = '100000'+lastRes.median;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(mediandigit2 == 1){
                                                                   medians1 = '10000'+lastRes.median;
                                                                 }else if(mediandigit2 == 2){
                                                                   medians1 = '1000'+lastRes.median;
                                                                 }else if(mediandigit2 == 3){
                                                                   medians1 = '100'+lastRes.median;
                                                                 }else if(mediandigit2 == 4){
                                                                   medians1 = '10'+lastRes.median;
                                                                 }else if(mediandigit2 == 5){
                                                                   medians1 = '1'+lastRes.median;
                                                                 }



                                                      //console.log('lengg',mintlength);
                                                      /*if(mintlength == '2'){
                                                        var distancethree  = minutes;
                                                      }else{
                                                        var distancethree = lastRes.duration_in_traffic.text; 
                                                      }*/
                                                                
                                                       html2 += "<tr>";
                                                       if(bgcolorr == '#FFFF'){
                                                        html2 += "<td style='background-color:"+firstcase2+"'>";
                                                       }else{
                                                        html2 += "<td style='background-color:"+bgcolorr+"'>";
                                                       }
                                                       html2 += "<span style='display:none'>"+medians1+"</span>"+lastRes.duration_in_traffic.text+"<a href='https://www.google.co.in/maps/dir/"+originArr+"/"+destinationArr+"' target='_blank'><img src='shedulesheet/map_icon.png' height='20' width='20' id='icon_map_"+resKey+"' alt='#' target='_blank'></a>"
                                                       html2 += "</td>";
                                                     html2 += "<td style='background-color:"+firstcase2+"'><span></span><span id='myroute"+resKey+"' class='mycharticon'>"+lastRes.techname+"</span>";
                                                     if(lastRes.newtech == '1'){
                                                     html2 += "<span class='newhire'>New Hire!</span><span class='newhire'>"+lastRes.rowcounticon+" Completed Job(s)</span>";
                                                     }                                                      
                                                     html2 += "</p>";
                                                     html2 += "</td>";
                                                     html2 += "<td style='background-color:"+firstcase2+"'>";
                                                     html2 += "<span style='color:blue'>"+lastRes.asgId_arr+' '+"</span>"; 
                                                     html2 += "<span>"+respAssign+"</span>";
                                                     html2 += "</td>";
                                                     if(bgcolorr1 == '#FFFF'){
                                                      html2 += "<td style='background-color:"+firstcase2+"'>";
                                                     }else{
                                                      html2 += "<td style='background-color:"+bgcolorr1+"'>";
                                                     }                                                    
                                                     html2 += "<div class='dateshow'>"; 
                                                     html2 += "<span id='nexttimesD"+resKey+"'>"+lastRes.next_date+"</span>";
                                                     html2 += "<span id='nexttimes"+resKey+"'></span>";
                                                     html2 += "<div class='iconshow'>";
                                                     html2 += "<i class='fas fa-sync-alt' id='nextpop"+resKey+"' aria-hidden='true'></i>";
                                                     html2 += "<div class='tblshow nexttblshow' id='nexttbl"+resKey+"' style='display:none'>";
                                                     html2 += "<table>";
                                                     html2 += "<tr><td width='100'>Date</td><td><input type='hidden' id='technme"+resKey+"' value='"+lastRes.techname+"'><input type='date' id='datepicker"+resKey+"'></td></tr>";                                                  
                                                     html2 += "<tr><td>Time</td><td><div class='timetbl'><input type='text' id='time1"+resKey+"' style='max-width: 32px;'><input type='text' id='time2"+resKey+"' style='max-width: 32px;'><select id='ampm"+resKey+"' name='' style='max-width: 44px;'><option value='AM'>AM</option><option value='PM'>PM</option></select></div></td></tr>";
                                                     html2 += "<tr><td>Contact Failed</td><td><input type='checkbox' id='Cfailed"+resKey+"'></td></tr>";
                                                     html2 += "<tr><td>Notes</td><td><textarea id='notes"+resKey+"'></textarea></td></tr>";                                                  
                                                     html2 += "<tr><td  colspan='2' align='right'><input type='button' id='btnNext"+resKey+"' value='submit' class='btn btn-primary'></td></tr>";                                                  
                                                     html2 += "</table>";
                                                     html2 += "</div>";
                                                     html2 += "</div>";
                                                     html2 += "</div>";
                                                     html2 += "</td>";
                                                     html2 += "<td style='background-color:"+firstcase2+"'>";
                                                     html2 += "<div class='histlast'><span id='lastupp"+resKey+"'></span>";
                                                     html2 += "<span id='lastupD"+resKey+"'>"+lastRes.last_update+"</span>";
                                                     html2 += "<div class='histNotes'>";
                                                     html2 += "<i class='fas fa-file-alt' id='lastup"+resKey+"' aria-hidden='true'></i>";

                                                  var techhname = lastRes.techname;
                                                  $.ajax({
                                                              url: "getnexthistory.php",
                                                              type: 'POST',
                                                              dataType : "json",                                                              
                                                              cache: false,
                                                              data: {tchname : techhname},
                                                              success: function(data){
                                                                console.log(data);
                                                  
                                                                var len = data.length;
                                                                //console.log('legnth',len);
                                                                html2 += "<table class='tblpop'>";
                                                                html2 += "<tr>";
                                                                html2 += "<td><b>Office User</b></td>";
                                                                html2 += "<td><b>Update Date</b></td>";
                                                                html2+= "<td><b>Availability Entered</b></td>";
                                                                html2 += "<td><b>Notes</b></td>";
                                                                html2 += "</tr>";
                                                                for (var i=0; i<len; i++) {
                                                                  var user = data[i].user;
                                                                  //console.log('userrr',user);
                                                                  var failed = data[i].failed;
                                                                  var last_update = data[i].last_update;
                                                                  var next_available = data[i].next_available;
                                                                  var notes = data[i].notes;
                                                                 html2 += "<tr><td>"+user+"</td><td>"+last_update+"</td><td>"+next_available+"</td><td>"+notes+"</td></tr>";
                                                                }
                                                                html2 += "</table>";
                                                                $("#ShowTable1"+resKey).append(html2);

                                                                                                                                          
                                                              }

                                                            });

                                                     html2 += "<div id='ShowTable1"+resKey+"' class='tblshow1' style='display:none'></div>";
                                                     html2 += "</div>";
                                                     html2 += "</div>";
                                                     html2 += "</td>";
                                                     html2 += "</tr>";

                                                     $("#ShowTable").append(html2);

                                                     setTimeout(function(){ 
                                                 $("#table_sorting").tablesorter({
                          

                                                                    // sort on the third column, order asc
                                                       sortList: [[0,1]]
                                                 });
                                             }, 4000);
                                                     }else{
                                                      var distancethree = '';
                                                      var mintlength = minutes.toString().length;
                                                      var firstcase1 = '';
                                                      var firstcase1 = '#FF8187';

                                                       if(mintlength == 1){
                                                                   distancethree = '1111'+minutes;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(SingleDigit == 2){
                                                                   distancethree = '111'+minutes;
                                                                 }else if(SingleDigit == 3){
                                                                   distancethree = '11'+minutes;
                                                                 }else if(SingleDigit == 4){
                                                                   distancethree = '1'+minutes;
                                                                 }else{
                                                                  distancethree = minutes;
                                                                 }

                                                                 var mediandigit1 = '';
                                                                 var medians ='';
                                                                 var mediandigit1 = lastRes.median.toString().length;
                                                                 console.log(mediandigit1);
                                                                 if(mediandigit1 == 0){
                                                                   medians = '000000'+lastRes.median;
                                                                   //console.log('single minute',minutes1);
                                                                 }else if(mediandigit1 == 1){
                                                                   medians = '00000'+lastRes.median;
                                                                 }else if(mediandigit1 == 2){
                                                                   medians = '0000'+lastRes.median;
                                                                 }else if(mediandigit1 == 3){
                                                                   medians = '000'+lastRes.median;
                                                                 }else if(mediandigit1 == 4){
                                                                   medians = '00'+lastRes.median;
                                                                 }else if(mediandigit1 == 5){
                                                                   medians = '0'+lastRes.median;
                                                                 }



                                                      //console.log('lengg',mintlength);
                                                      /*if(mintlength == '2'){
                                                        var distancethree  = minutes;
                                                      }else{
                                                        var distancethree = lastRes.duration_in_traffic.text; 
                                                      }*/
                                                                
                                                       html3 += "<tr>";
                                                       if(bgcolorr == '#FFFF'){
                                                        html3 += "<td style='background-color:"+firstcase1+"'>";
                                                       }else{
                                                        html3 += "<td style='background-color:"+bgcolorr+"'>";
                                                       }
                                                       html3 += "<span style='display:none'>"+medians+"</span>"+lastRes.duration_in_traffic.text+"<a href='https://www.google.co.in/maps/dir/"+originArr+"/"+destinationArr+"' target='_blank'><img src='shedulesheet/map_icon.png' height='20' width='20' id='icon_map_"+resKey+"' alt='#' target='_blank'></a>"
                                                       html3 += "</td>";
                                                     html3 += "<td style='background-color:"+firstcase1+"'><span></span><span id='myroute"+resKey+"' class='mycharticon'>"+lastRes.techname+"</span>";
                                                     if(lastRes.newtech == '1'){
                                                     html3 += "<span class='newhire'>New Hire!</span><span class='newhire'>"+lastRes.rowcounticon+" Completed Job(s)</span>";
                                                     }                                                      
                                                     html3 += "</p>";
                                                     html3 += "</td>";
                                                     html3 += "<td style='background-color:"+firstcase1+"'>";
                                                     html3 += "<span style='color:blue'>"+lastRes.asgId_arr+' '+"</span>"; 
                                                     html3 += "<span>"+respAssign+"</span>";
                                                     html3 += "</td>";
                                                     if(bgcolorr1 == '#FFFF'){
                                                      html3 += "<td style='background-color:"+firstcase1+"'>";
                                                     }else{
                                                      html3 += "<td style='background-color:"+bgcolorr1+"'>";
                                                     }
                                                     html3 += "<div class='dateshow'>"; 
                                                     html3 += "<span id='nexttimesD"+resKey+"'>"+lastRes.next_date+"</span>";
                                                     html3 += "<span id='nexttimes"+resKey+"'></span>";
                                                     html3 += "<div class='iconshow'>";
                                                     html3 += "<i class='fas fa-sync-alt' id='nextpop"+resKey+"' aria-hidden='true'></i>";
                                                     html3 += "<div class='tblshow nexttblshow' id='nexttbl"+resKey+"' style='display:none'>";
                                                     html3 += "<table>";
                                                     html3 += "<tr><td width='100'>Date</td><td><input type='hidden' id='technme"+resKey+"' value='"+lastRes.techname+"'><input type='date' id='datepicker"+resKey+"'></td></tr>";                                                  
                                                     html3 += "<tr><td>Time</td><td><div class='timetbl'><input type='text' id='time1"+resKey+"' style='max-width: 32px;'><input type='text' id='time2"+resKey+"' style='max-width: 32px;'><select id='ampm"+resKey+"' name='' style='max-width: 44px;'><option value='AM'>AM</option><option value='PM'>PM</option></select></div></td></tr>";
                                                     html3 += "<tr><td>Contact Failed</td><td><input type='checkbox' id='Cfailed"+resKey+"'></td></tr>";
                                                     html3 += "<tr><td>Notes</td><td><textarea id='notes"+resKey+"'></textarea></td></tr>";                                                  
                                                     html3 += "<tr><td  colspan='2' align='right'><input type='button' id='btnNext"+resKey+"' value='submit' class='btn btn-primary'></td></tr>";                                                  
                                                     html3 += "</table>";
                                                     html3 += "</div>";
                                                     html3 += "</div>";
                                                     html3 += "</div>";
                                                     html3 += "</td>";
                                                     html3 += "<td style='background-color:"+firstcase1+"'>";
                                                     html3 += "<div class='histlast'><span id='lastupp"+resKey+"'></span>";
                                                     html3 += "<span id='lastupD"+resKey+"'>"+lastRes.last_update+"</span>";
                                                     html3 += "<div class='histNotes'>";
                                                     html3 += "<i class='fas fa-file-alt' id='lastup"+resKey+"' aria-hidden='true'></i>";

                                                  var techhname = lastRes.techname;
                                                  $.ajax({
                                                              url: "getnexthistory.php",
                                                              type: 'POST',
                                                              dataType : "json",                                                              
                                                              cache: false,
                                                              data: {tchname : techhname},
                                                              success: function(data){
                                                                console.log(data);
                                                  
                                                                var len = data.length;
                                                                //console.log('legnth',len);
                                                                html3 += "<table class='tblpop'>";
                                                                html3 += "<tr>";
                                                                html3 += "<td><b>Office User</b></td>";
                                                                html3 += "<td><b>Update Date</b></td>";
                                                                html3+= "<td><b>Availability Entered</b></td>";
                                                                html3 += "<td><b>Notes</b></td>";
                                                                html3 += "</tr>";
                                                                for (var i=0; i<len; i++) {
                                                                  var user = data[i].user;
                                                                  //console.log('userrr',user);
                                                                  var failed = data[i].failed;
                                                                  var last_update = data[i].last_update;
                                                                  var next_available = data[i].next_available;
                                                                  var notes = data[i].notes;
                                                                 html3 += "<tr><td>"+user+"</td><td>"+last_update+"</td><td>"+next_available+"</td><td>"+notes+"</td></tr>";
                                                                }
                                                                html3 += "</table>";
                                                                $("#ShowTable1"+resKey).append(html3);

                                                                                                                                          
                                                              }

                                                            });

                                                     html3 += "<div id='ShowTable1"+resKey+"' class='tblshow1' style='display:none'></div>";
                                                     html3 += "</div>";
                                                     html3 += "</div>";
                                                     html3 += "</td>";
                                                     html3 += "</tr>";

                                                     $("#ShowTable").append(html3);

                                                     setTimeout(function(){ 
                                                 $("#table_sorting").tablesorter({
                          

                                                                    // sort on the third column, order asc
                                                       sortList: [[0,1]]
                                                 });
                                             }, 4000);
                                                     }            
                                                                                                           
                                                                                                       
                                                     $(document).ready(function(){
                                                        /*$("#myroute"+resKey).mouseover(function(){
                                                                Tip(altmeg);
                                                          });
                                                        $("#myroute"+resKey).mouseout(function() {
                                                            UnTip();
                                                          });*/
                                                        //$("#datepicker"+resKey).datepicker({ minDate: 0 });
                                                        
                                                        count1 = 0
                                                        $("#nextpop"+resKey).click(function() {
                                                         // alert("ASdfsadfasdf");
                                                           count1 += 1;
                                                          //alert(count);
                                                        if(count1 % 2 == 0){
                                                          $('#nexttbl'+resKey).css('display','none');
                                                        }else{
                                                          $('#nexttbl'+resKey).css('display','block');
                                                        }
                                                        });
                                                        /*$("#lastup"+resKey).click(function() {
                                                          myroute();
                                                        });*/

                                                        $("#btnNext"+resKey).click(function() {
                                                          var datepicker = $('#datepicker'+resKey).val();
                                                          var time1 = $('#time1'+resKey).val();
                                                          var time2 = $('#time2'+resKey).val();
                                                          var ampm = $('#ampm'+resKey).val();
                                                          var Cfailed = '';
                                                          //var Cfailed = $('#Cfailed'+resKey).val();
                                                          if($('#Cfailed'+resKey).is(":checked"))
                                                          {
                                                              var Cfailed = 'on';
                                                          }else{
                                                              var Cfailed = '';
                                                          }

                                                          var notes = $('#notes'+resKey).val();
                                                          var techhname = $('#technme'+resKey).val();
                                                          //var techhname = lastRes.techname;
                                                          var user =  '<?php echo($user);?>';
                                                          $.ajax({
                                                              url: "getnextsbt.php",
                                                              type: 'POST',
                                                              dataType: "json",
                                                              cache: false,
                                                              data: {tchname : techhname,datepicker : datepicker,time1 : time1,time2 : time2,ampm : ampm,Cfailed : Cfailed,notes : notes,user : user},
                                                              success: function(data){
                                                                $('#nexttbl'+resKey).css('display','none');
                                                                //console.log(data.nexttime);
                                                                //console.log(data.lastupdate);
                                                                  var dates = new Date(data.lastupdate);
                                                                  var hourses = dates.getHours();
                                                                  var hourses = hourses % 12;
                                                                  var hourses = hourses ? hourses : 12; 
                                                                  var ampmup = dates.getHours() >= 12 ? 'PM' : 'AM';
                                                                  var newDateup = dates.getMonth() + 1+'/'+dates.getDate()+'/'+dates.getFullYear()+' '+hourses+':'+dates.getMinutes()+' '+ampmup;

                                                                 $('#lastupp'+resKey).html('<p>'+newDateup+'</p>');
                                                                 
                                                                 if(data.Cfailed == 'on'){
                                                                  $('#nexttimes'+resKey).html('<p>Contact Failed</p>');
                                                                 }else{
                                                                  var date = new Date(data.nexttime);
                                                                  var hours = date.getHours();
                                                                  var hours = hours % 12;
                                                                  var hours = hours ? hours : 12; 
                                                                  var ampm2 = date.getHours() >= 12 ? 'PM' : 'AM';
                                                                  var newDate = date.getMonth() + 1+'/'+date.getDate()+' '+hours+':'+date.getMinutes()+' '+ampm2;
                                                                  $('#nexttimes'+resKey).html('<p>'+newDate+'</p>');
                                                                 }
                                                                 $('#lastupD'+resKey).css('display','none');
                                                                 $('#nexttimesD'+resKey).css('display','none');
                                                                 //$('#lastupD'+resKey).text(data.lastupdate);
                                                              }

                                                            });
                                                          //alert(datepicker);
                                                          
                                                        });

                                                        var count = 0;
                                                        $("#lastup"+resKey).click(function() {
                                                        //alert("sadfsad");
                                                        $('#ShowTable1'+resKey).css('display','block');  
                                                          count += 1;
                                                          //alert(count);
                                                        if(count % 2 == 0){
                                                          $('#ShowTable1'+resKey).css('display','none');
                                                        }else{
                                                          $('#ShowTable1'+resKey).css('display','block');
                                                        }
                                                          
                                                         });

                                                        });
                                                     
                                                 }

                                                             console.log(html);
                                                             count++;
                                                             
                                               });
                                                         //var fhtml = html1+html;


                                                     

                                                           });
                                                 

                                                 return true;
                                             
                                             }

                                             </script>