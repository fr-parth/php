<?php
/**
 * SmartCookie
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	SmartCookie
 * @author	Sudhir Deshmukh
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('imageurl'))
{
	/**
	 * imageurl
	 *
	 * To check the available image url
	 * 
	 * type=sclogo or avatar else sorry image not available is shown
	   img_loc is the path to image in  /Assets/images/ folder
	 * 
	 */
	function imageurl($value,$type='',$img=''){
			//$logoUrl=@get_headers(base_url('/Assets/images/sp/profile/'.$value));
			$server_name = $_SERVER['SERVER_NAME'];
			if($img=='sp_profile')
			{
				$logoexist="https://$server_name/core/".$value;
			}
			elseif($img=='product')
			{
							
				$logoexist="https://$server_name/Assets/images/sp/productimage/".$value;
			}
			elseif($img=='spqr')
			{
				$logoexist="https://$server_name/Assets/images/sp/coupon_qr/".$value;
			}
			else
			{
				if($type=='sclogo'){
					$logoexist="https://$server_name/Assets/images/sp/profile/newlogo.png";
				}elseif($type=='avatar'){
					$logoexist="https://$server_name/Assets/images/avatar/avatar_2x.png";
				}else{
					$logoexist="https://$server_name/Assets/images/sp/profile/imgnotavl.png";
				}				
			}
			return $logoexist;
		}
}
		