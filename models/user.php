<?php

    class User extends model {
        public $id;
        public $name;
        public $password;
        public $password_rep;
        public $salt;
        public $role;
        public $pic;

        public $voornaam;
        public $achternaam;
        public $geslacht;
        public $geboorte_datum;
        public $adres;

        public function rules()
        {
            return [
                [ ['name', 'password', 'voornaam', 'achternaam', 'geslacht', 'geboorte_datum', 'adres'], 'required' ],

                [ ['name'], 'unique' ],
                
                [ ['password', 'password_rep'], 'password' ],

                [ ['geslacht'], 'in', ['m', 'f'] ],
                
                [ ['name', 'password', 'voornaam', 'achternaam', 'geslacht'], 'string' ],

                [ ['pic'], 'image', 400 ],

                [ ['geboorte_datum'], 'date' ],

                [ ['adres'], 'adres' ]
            ];
        }

        public function attributes()
        {
            return [
                'name' => 'Gebruikersnaam',
                'password' => 'Wachtwoord',
                'password_rep' => 'Wachtwoord herhalen',
                'pic' => 'Afbeelding',
                'voornaam' => 'Voornaam',
                'achternaam' => 'Achternaam',
                'geslacht' => 'Geslacht',
                'geboorte_datum' => 'Geboorte datum',
                'adres' => 'Address'
            ];
        }

        public function login() {
            $_SESSION['user'] = [
                "id" => $this->id,
                "name" => $this->name,
                "password" => $this->password,
                "salt" => $this->salt,
                "role" => $this->role,
                "pic" => $this->pic
            ];
        }

        public function isAdmin() {
            if ($_SESSION['user']['role'] == 777) {
                return true;
            } else {
                return false;
            }
        }

        public static function role($text) {
            switch ($text) {
                case 'User':
                    return 1;
                    break;
                case 'Admin':
                    return 777;
                    break;
                case 1:
                    return 'User';
                    break;
                case 777:
                    return 'Admin';
                    break;
                default:
                    return false;
                    break;
            }
        }
		
		public static function searchByName($text, $limit, $offset) {
			return Sql::Search('user', 'name', $text, $limit, $offset);
		}
		
        public static function all() {
            return Sql::Get('user');
        }

        public static function find($id) {
            $result = Sql::Get('user', 'id', $id);

            if ( isset($result[0]) ) {
                $user = new User();
                $user->load( $result[0] );
                return $user;
            } else {
                return false;
            }

        }

        public static function findByName($name) {
            $result = Sql::Get('user', 'name', $name);

            if ( isset($result[0]) ) {
                $user = new User();
                $user->load( $result[0] );
                return $user;
            } else {
                return false;
            }
        }

        public static function findByRole($number, $lt) {
            if (!$lt && false) {
                $result = $col->find( ["role" => ['$lt' => $number]] );
            } else {
                $result = Sql::Get('user', 'role', $number);
            }

            return $result;
        }

        public function save() {
            if ( !self::find($this->id) ) {
                if ( !self::findByName($this->name) ) {
                    return Sql::Save('user', [
                        'id' => $this->id,
                        'name' => $this->name,
                        'password' => $this->password,
                        'salt' => $this->salt,
                        'role' => $this->role,
                        'pic' => $this->pic,
                        'voornaam' => $this->voornaam,
                        'achternaam' => $this->achternaam,
                        'geslacht' => $this->geslacht,
                        'geboorte_datum' => $this->geboorte_datum,
                        'adres' => $this->adres
                    ]);
                } else {
                    return false;
                }
            } else {
                return Sql::Update('user', 'id', $this->id, [
                    'id' => $this->id,
                    'name' => $this->name,
                    'password' => $this->password,
                    'salt' => $this->salt,
                    'role' => $this->role,
                    'pic' => $this->pic,
                    'voornaam' => $this->voornaam,
                    'achternaam' => $this->achternaam,
                    'geslacht' => $this->geslacht,
                    'geboorte_datum' => $this->geboorte_datum,
                    'adres' => $this->adres
                ]);
            }
        }

        public function delete() {
            $user = self::find($this->id);
            
            if ($user) {
                if (explode('/', $user->pic)[1] == 'img') {
                    if ( !unlink($user->pic) ) {
                        return false;
                    }
                }

                return Sql::Delete('user', 'id', $this->id);
            } else {
                return false;
            }
        }
    }