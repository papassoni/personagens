<?php

namespace App\SWAPI;

use \GuzzleHttp\Client;


class SwapiClient {

	protected $url = 'https://swapi.dev/api/';
	protected $client;

	public function __construct(){
		$this->client = new \GuzzleHttp\Client(['base_uri' => $this->url]);
	}

	public function getPeoples($page = 1, $search = ''){

		$endpoint = 'people/?page='.$page;
		if($search){
			$endpoint .= '&search='.$search;
		}

		$res = $this->client->request('GET', $endpoint);

		//echo ($res->getBody());
		if($res->getStatusCode()==200){

			return json_decode($res->getBody());

		}
		
		return false;

	}

	public function getPeople($id){

		$endpoint = 'people/'.$id;
		
		$res = $this->client->request('GET', $endpoint);

		//echo ($res->getBody());
		if($res->getStatusCode()==200){

			return json_decode($res->getBody());

		}
		
		return false;

	}

	public function getEspecies($species){
		$especies = [] ;
	
		foreach ($species as $key => $value) {
			$endpoint = 'species/'.preg_replace('/[^0-9]/', '', $value);
			$res = $this->client->request('GET', $endpoint);
			$especie = json_decode($res->getBody());
			$especies[] =  $especie->name ;
		}

		return join(', ', $especies);
	}

	public function getFilms($films){
		$filmes = [] ;
	
		foreach ($films as $key => $value) {
			$endpoint = 'films/'.preg_replace('/[^0-9]/', '', $value);
			$res = $this->client->request('GET', $endpoint);
			$film = json_decode($res->getBody());
			$filmes[] = (object) [ 'year'=> preg_replace('/-[0-9]{2}-[0-9]{2}/','',$film->release_date),
					'title'=>$film->title];
		}

		return $filmes;
	}

	public function getPeopleByName($name){
		$people = $this->getPeoples(1, $name);
		if($people->results){
			$detalhes = $people->results[0];
			$detalhes->id = preg_replace('/[^0-9]/', '', $detalhes->url);
			$detalhes->filmes = $this->getFilms($detalhes->films);
			$detalhes->especies = $this->getEspecies($detalhes->species);
		}
		return $detalhes;
	}

	public function getPeopleById($id){
		$people = $this->getPeople($id);
		
		$detalhes = $people;
		$detalhes->id = preg_replace('/[^0-9]/', '', $detalhes->url);
		$detalhes->filmes = $this->getFilms($detalhes->films);
		$detalhes->especies = $this->getEspecies($detalhes->species);
		
		return $detalhes;

	}

	public function getAllPeoplesNames(){

		$page=1;
		$keep = true;
		$nomes = [];

		while ($keep){
			$keep = false;
			$peoples = $this->getPeoples($page);

			$page++;
			if($peoples){
				foreach ($peoples->results as $key => $value) {
					$nomes[] = $value->name;
				}
			}
			if($peoples->next){
				$keep = true;
			}
		}

		return $nomes;

	}
	

}