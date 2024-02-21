<?php
include dirname(__DIR__, 3) . "/common/config/config.php";
?>
<!-- Modal -->
<div class="modal fade product_modal" id="product_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Product Detail</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <?php
         $id = $_GET['product_id'];
         $sql = "SELECT * FROM products WHERE id = $id";
         $result = $database_connection->query($sql);
         if ($result->num_rows > 0) {
            while ($product_data = $result->fetch_assoc()) {
         ?>
               <div class="modal-body">
                  <div class="product_images">
                     <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                           <div class="carousel-item active" data-bs-interval="10000">
                              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJ0AAACUCAMAAAC+99ssAAAAMFBMVEXk5ueutLfr7O3n6eqrsbTGysy8wcPh4+TT1ti3vL+yuLvAxMfKztCorrLd4OHZ3N3rC+7NAAADrElEQVR4nO2b23bbIBBFgUHiKvj/vy3IjuM4sQWDGLS62E9p89C9DgziMmVsMplMJpPJZDKZTCaTyWRCCIAKWvvFJbyOgcFoo28AtDNWPuB29UpcQhAguCT0gtyMVuP9RFx/u+1s1g8e4D9z+w6Q66Fymr932/3cuOEF99kt69k4SC+YQ7k8/fwQPWUL3HJ8XtDLhTK3nN5Cnl5pcrf0iPWgQi7paVI9WEoK4kmPcmEBXSfHpVF0dqxSjnTqFazCv/Wowqse1x1DFB6sGDtOU7cQN4ycXCnkmMBFx2UkkIPyT9iLnSP43oLHRZf0+ssxhhxYmu9ZwMqloe1vp1EVu2NCbzmxouU47161Aj2weeL1tqvfADzZdd8kxxa7tfOKl06wDdjedr7FTva2q9yyv9h1nndtdltfOdS2mNDu2tlde9411Szvvt61ZNd7vbv2t4IBfgOVjtyd5S6+R7n2/q5pb9z/tgJ7YKQ5V1z7TNZwnqW4SFFYOZLLbWzVyu7nxR3ceVs6EjnsHo/qSSpiolupLo4xmzyye2N27Tv3+n0U0bXsnfq3Hko7JoreZh9ytO9k6YtRobdRy6U12ZbqkT+AJqA0vRFyCVW0lyKfc1+I48qVJoxr+YgH/SibG9vOs3zyM6OaUb4Q73qNcp/WBRrdQC2WvximP65XcMsIiH6123brvts2bpwP1+i/2wFgKmi/JLyOSl0ktgcAIO6kH0fbPMhSoKL2OTnn9vRy52f+66FeoFSI3lmZpxyXt8q4935uqS68DoENCVKIoJfVZIu334n0S7MumrhA0j8W0yryuoy8UeTcLpFR1YlQerEfIvtzZbaOpIX2tvbWqN0FuXWdNwTA9FqX2s8Ee/YgAyymZKp98JN26VPDoHyb2pfg0iE/8MXniCM/68/OL57ltmPP3M1D2Qmigm09rX5BnxrcjuTnnNRScA3PO+85JT5R1i+O4IQWeGh4PDmktQW+7bH4kLZreGSHZ4Vey71eb7l8V4BND3rVww89bHpNzR0Vepj0OhfEkx6iNMB3XEpe9KoXFsC8mKD1ajcF2IdEJHVX8oKmIr6oe/Vu6wHE6NWMbc1/KTpJr9xOoB/X8XYVywrZYvJE6cs32Tr8THF4gXzW7XqF2dHPut2u7IsBZoRcOkaWDeyImsiUHDPwvTqNFHXnjRrYshazMRWbKaha8k/sN9tx8+CwaVe2poz4UNwpaKntf0p8y3E7sjJyGPx4ZB/PXQM4lJtMJpP/lH9BaDBl8zmksAAAAABJRU5ErkJggg==" class="d-block w-100" style="height: 15rem;">
                           </div>
                           <div class="carousel-item" data-bs-interval="2000">
                              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJ0AAACUCAMAAAC+99ssAAAAMFBMVEXk5ueutLfr7O3n6eqrsbTGysy8wcPh4+TT1ti3vL+yuLvAxMfKztCorrLd4OHZ3N3rC+7NAAADrElEQVR4nO2b23bbIBBFgUHiKvj/vy3IjuM4sQWDGLS62E9p89C9DgziMmVsMplMJpPJZDKZTCaTyWRCCIAKWvvFJbyOgcFoo28AtDNWPuB29UpcQhAguCT0gtyMVuP9RFx/u+1s1g8e4D9z+w6Q66Fymr932/3cuOEF99kt69k4SC+YQ7k8/fwQPWUL3HJ8XtDLhTK3nN5Cnl5pcrf0iPWgQi7paVI9WEoK4kmPcmEBXSfHpVF0dqxSjnTqFazCv/Wowqse1x1DFB6sGDtOU7cQN4ycXCnkmMBFx2UkkIPyT9iLnSP43oLHRZf0+ssxhhxYmu9ZwMqloe1vp1EVu2NCbzmxouU47161Aj2weeL1tqvfADzZdd8kxxa7tfOKl06wDdjedr7FTva2q9yyv9h1nndtdltfOdS2mNDu2tlde9411Szvvt61ZNd7vbv2t4IBfgOVjtyd5S6+R7n2/q5pb9z/tgJ7YKQ5V1z7TNZwnqW4SFFYOZLLbWzVyu7nxR3ceVs6EjnsHo/qSSpiolupLo4xmzyye2N27Tv3+n0U0bXsnfq3Hko7JoreZh9ytO9k6YtRobdRy6U12ZbqkT+AJqA0vRFyCVW0lyKfc1+I48qVJoxr+YgH/SibG9vOs3zyM6OaUb4Q73qNcp/WBRrdQC2WvximP65XcMsIiH6123brvts2bpwP1+i/2wFgKmi/JLyOSl0ktgcAIO6kH0fbPMhSoKL2OTnn9vRy52f+66FeoFSI3lmZpxyXt8q4935uqS68DoENCVKIoJfVZIu334n0S7MumrhA0j8W0yryuoy8UeTcLpFR1YlQerEfIvtzZbaOpIX2tvbWqN0FuXWdNwTA9FqX2s8Ee/YgAyymZKp98JN26VPDoHyb2pfg0iE/8MXniCM/68/OL57ltmPP3M1D2Qmigm09rX5BnxrcjuTnnNRScA3PO+85JT5R1i+O4IQWeGh4PDmktQW+7bH4kLZreGSHZ4Vey71eb7l8V4BND3rVww89bHpNzR0Vepj0OhfEkx6iNMB3XEpe9KoXFsC8mKD1ajcF2IdEJHVX8oKmIr6oe/Vu6wHE6NWMbc1/KTpJr9xOoB/X8XYVywrZYvJE6cs32Tr8THF4gXzW7XqF2dHPut2u7IsBZoRcOkaWDeyImsiUHDPwvTqNFHXnjRrYshazMRWbKaha8k/sN9tx8+CwaVe2poz4UNwpaKntf0p8y3E7sjJyGPx4ZB/PXQM4lJtMJpP/lH9BaDBl8zmksAAAAABJRU5ErkJggg==" class="d-block w-100" style="height: 15rem;">
                           </div>
                           <div class="carousel-item">
                              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJ0AAACUCAMAAAC+99ssAAAAMFBMVEXk5ueutLfr7O3n6eqrsbTGysy8wcPh4+TT1ti3vL+yuLvAxMfKztCorrLd4OHZ3N3rC+7NAAADrElEQVR4nO2b23bbIBBFgUHiKvj/vy3IjuM4sQWDGLS62E9p89C9DgziMmVsMplMJpPJZDKZTCaTyWRCCIAKWvvFJbyOgcFoo28AtDNWPuB29UpcQhAguCT0gtyMVuP9RFx/u+1s1g8e4D9z+w6Q66Fymr932/3cuOEF99kt69k4SC+YQ7k8/fwQPWUL3HJ8XtDLhTK3nN5Cnl5pcrf0iPWgQi7paVI9WEoK4kmPcmEBXSfHpVF0dqxSjnTqFazCv/Wowqse1x1DFB6sGDtOU7cQN4ycXCnkmMBFx2UkkIPyT9iLnSP43oLHRZf0+ssxhhxYmu9ZwMqloe1vp1EVu2NCbzmxouU47161Aj2weeL1tqvfADzZdd8kxxa7tfOKl06wDdjedr7FTva2q9yyv9h1nndtdltfOdS2mNDu2tlde9411Szvvt61ZNd7vbv2t4IBfgOVjtyd5S6+R7n2/q5pb9z/tgJ7YKQ5V1z7TNZwnqW4SFFYOZLLbWzVyu7nxR3ceVs6EjnsHo/qSSpiolupLo4xmzyye2N27Tv3+n0U0bXsnfq3Hko7JoreZh9ytO9k6YtRobdRy6U12ZbqkT+AJqA0vRFyCVW0lyKfc1+I48qVJoxr+YgH/SibG9vOs3zyM6OaUb4Q73qNcp/WBRrdQC2WvximP65XcMsIiH6123brvts2bpwP1+i/2wFgKmi/JLyOSl0ktgcAIO6kH0fbPMhSoKL2OTnn9vRy52f+66FeoFSI3lmZpxyXt8q4935uqS68DoENCVKIoJfVZIu334n0S7MumrhA0j8W0yryuoy8UeTcLpFR1YlQerEfIvtzZbaOpIX2tvbWqN0FuXWdNwTA9FqX2s8Ee/YgAyymZKp98JN26VPDoHyb2pfg0iE/8MXniCM/68/OL57ltmPP3M1D2Qmigm09rX5BnxrcjuTnnNRScA3PO+85JT5R1i+O4IQWeGh4PDmktQW+7bH4kLZreGSHZ4Vey71eb7l8V4BND3rVww89bHpNzR0Vepj0OhfEkx6iNMB3XEpe9KoXFsC8mKD1ajcF2IdEJHVX8oKmIr6oe/Vu6wHE6NWMbc1/KTpJr9xOoB/X8XYVywrZYvJE6cs32Tr8THF4gXzW7XqF2dHPut2u7IsBZoRcOkaWDeyImsiUHDPwvTqNFHXnjRrYshazMRWbKaha8k/sN9tx8+CwaVe2poz4UNwpaKntf0p8y3E7sjJyGPx4ZB/PXQM4lJtMJpP/lH9BaDBl8zmksAAAAABJRU5ErkJggg==" class="d-block w-100" style="height: 15rem;">
                           </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                           <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                           <span class="carousel-control-next-icon" aria-hidden="true"></span>
                           <span class="visually-hidden">Next</span>
                        </button>
                     </div>
                  </div>
                  <div class="product_name">
                     <label for="product_name_in_modal" class="product_name_in_modal mt-2 mb-2">Name :</label>
                     <div class="product_name_in_modal" name="product_name_in_modal" id="product_name_in_modal"><?php echo $product_data['name']; ?></div>
                  </div>
                  <div class="product_modal_description">
                     <label for="products_description" class="edit_products_description mt-2 mb-2">Description</label>
                     <div name="products_description_in_modal" class="products_description_in_modal" id="products_description_in_modal"><?php echo $product_data["description"]; ?></div>
                  </div>
               </div>
         <?php
            }
         }
         ?>
      </div>
   </div>
</div>