<?

// Pekeninos 1.0
// blog Model
// 11-2013
// Beto Ayesa contacto@phpninja.info

class blogModel extends ModelBase
{

		public function getAll(){


				$consulta = $this->db->prepare("SELECT * FROM blog LEFT JOIN categorys ON (blog.categorysId = categorys.categorysId)");
				$consulta->execute();
				$aux2 = $consulta->fetchAll();

				return $aux2;
		}
		
		public function getFieldValueById($field,$id){


				$consulta = $this->db->prepare("SELECT $field FROM blog LEFT JOIN categorys ON (blog.categorysId = categorys.categorysId) where blog.blogId ='".$id."' limit 1");
				$consulta->execute();
				$c = $consulta->fetch();
				$aux2 = $c[$field];

				return $aux2;
		}
		
		public function getByField($field,$val){


				$consulta = $this->db->prepare("SELECT * FROM blog LEFT JOIN categorys ON (blog.categorysId = categorys.categorysId) where blog.".$field." ='".$val."' ");
				$consulta->execute();
				$aux2 = $consulta->fetchAll();
				$this->cache->set("blog_".$field."_".$val,$aux2,600);
				return $aux2;
		}
	


		public function getByBlogId($id){


				$consulta = $this->db->prepare("SELECT * FROM blog LEFT JOIN categorys ON (blog.categorysId = categorys.categorysId) WHERE blog.blogId='$id' limit 1");
				$consulta->execute();
				$aux2 =  $consulta->fetch();

				return $aux2;

		}


		public function getByCategorysId($id){


				$consulta = $this->db->prepare("SELECT * FROM blog LEFT JOIN categorys ON (blog.categorysId = categorys.categorysId) WHERE blog.categorysId='$id' ");
				$consulta->execute();
				$aux2 =  $consulta->fetchAll();

				return $aux2;
		}


		
		
		public function search($params){
			$aux = $this->cache->get("blog_search_".$params['query']);
			if ($aux == null){
				$consulta = $this->db->prepare("SELECT * FROM blog LEFT JOIN categorys ON (blog.categorysId = categorys.categorysId) where title like '%".$params['query']."%' ");
				$consulta->execute();
				$aux2= $consulta->fetchAll();
				$this->cache->set("blog_search_".$params['query'],$aux2,600);
				return $aux2;
			}
			return $aux;
		}
		
		
		public function add($params){
			$consulta = $this->db->prepare("INSERT INTO blog (fecha,categorysId,title,slug,content) VALUES ('".$params['fecha']."','".$params['categorysId']."','".$params['title']."','".$params['slug']."','".$params['content']."')");
			$consulta->execute();
			if ($consulta->rowCount() > 0) return true;
			else return false;
		}

		public function edit($params){
			$consulta = $this->db->prepare("UPDATE blog SET fecha = '".$params['fecha']."',categorysId = '".$params['categorysId']."',title = '".$params['title']."',slug = '".$params['slug']."',content = '".$params['content']."'  where blogId='".$params['id']."'");
			$consulta->execute();
			if ($consulta->rowCount() > 0) return true;
			else return false;
		}

		public function delete($params){
			$consulta = $this->db->prepare("DELETE FROM blog where blogId='".$params['blogId']."'");
			$consulta->execute();
			if ($consulta->rowCount() > 0) return true;
			else return false;
		}
}