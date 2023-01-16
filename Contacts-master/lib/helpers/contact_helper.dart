import 'package:http/http.dart' as http;
import 'dart:convert';

class ContactHelper {
  final String _baseApiUrl = "http://localhost/contact_api/";

  Future saveContact(Contact contact) async {
    var data = new Map<String, dynamic>();
    data["name"] = contact.name;
    data["email"] = contact.email;
    data["phone"] = contact.phone;
    if (contact.img != null) data["img"] = contact.img;

    final response = await http.post(_baseApiUrl + "add.php", body: data);

    if (response.statusCode == 200) {
      contact.id = int.parse(response.body);
      print("Data tersimpan");
    }

    return contact;
  }

  Future<Contact> getContact(int id) async {
    final response = await http.post(_baseApiUrl + "rawSql.php",
        body: ({"sql": "SELECT * FROM contact WHERE id=$id;"}));

    if (response.statusCode == 200) {
      return Contact.fromMap(json.decode(response.body));
    } else {
      return null;
    }
  }

  Future<int> deleteContact(int id) async {
    final response = await http.post(_baseApiUrl + "rawSql.php",
        body: ({"sql": "DELETE FROM contact WHERE id=$id;"}));
    if (response.statusCode == 200) {
      return 1;
    } else {
      return 0;
    }
  }

  Future<int> updateContact(Contact contact) async {
    var data = new Map<String, dynamic>();
    print(contact);
    data["id"] = contact.id.toString();
    data["name"] = contact.name;
    data["email"] = contact.email;
    data["phone"] = contact.phone;
    if (contact.img != null) data["img"] = contact.img;

    final response = await http.post(_baseApiUrl + "edit.php", body: data);

    if (response.statusCode == 200) {
      print("Data tersimpan");
      return 1;
    } else {
      return 0;
    }
  }

  Future<List> getAllContacts() async {
    final response = await http.get(
      _baseApiUrl + "get.php",
    );

    var listContact = <Contact>[];

    if (response.statusCode == 200) {
      for (Map m in json.decode(response.body)) {
        m["id"] = int.parse(m["id"]);
        listContact.add(Contact.fromMap(m));
      }
    }

    print(listContact);
    return listContact;
  }

  Future<int> getNumber() async {
    final response = await http.post(_baseApiUrl + "rawSql.php",
        body: ({"sql": "SELECT COUNT(*) FROM contact;"}));
    if (response.statusCode == 200) {
      return int.parse(response.body);
    } else {
      return 0;
    }
  }
}

class Contact {
  int id;
  String name;
  String email;
  String phone;
  String img;

  Contact();

  Contact.fromMap(Map map) {
    id = map["id"];
    name = map["name"];
    email = map["email"];
    phone = map["phone"];
    img = map["img"];
  }

  Map toMap() {
    var map = <String, dynamic>{
      name: name,
      email: email,
      phone: phone,
      img: img
    };
    if (id != null) {
      map["id"] = id;
    }
    return map;
  }

  @override
  String toString() {
    return 'Contact('
        'id: $id,'
        'name: $name, '
        'email: $email, '
        'phone: $phone, '
        'img: $img)';
  }
}
