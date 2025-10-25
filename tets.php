<?php
// Fungsi untuk membaca dan memproses JSON
function readJsonFile($filePath) {
    if (!file_exists($filePath)) {
        echo "File case.json tidak ditemukan!";
        return false;  // Kembalikan false jika file tidak ada
    }

    // Membaca konten file JSON
    $jsonContent = file_get_contents($filePath);
    
    // Decode JSON
    $jsonData = json_decode($jsonContent, true);

    // Cek jika JSON valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error dalam format JSON: " . json_last_error_msg();
        return false;  // Kembalikan false jika format JSON tidak valid
    }

    return $jsonData;
}

// Path file case.json
$filePath = __DIR__ . '/assets/json/case.json';

// Membaca dan memproses data JSON
$pets = readJsonFile($filePath);

// Jika data JSON valid, lanjutkan dengan proses lainnya
if ($pets !== false) {
    // Fungsi untuk menambah hewan peliharaan baru
    function addPet(&$pets, $jenis, $ras, $nama, $karakteristik) {
        $pets[] = [
            "jenis" => $jenis,
            "ras" => $ras,
            "nama" => $nama,
            "karakteristik" => $karakteristik
        ];
    }

    // Menambah Badak Jawa "Rino"
    addPet($pets, "Badak", "Jawa", "Rino", "Pekerja keras");

    // Fungsi untuk mengambil hewan kesayangan Esa secara ascending dan descending
    function getFavoritePets($pets, $ascending = true) {
        $favoritePets = ["Otto", "Luna", "Milo", "Max", "Rino"]; // Nama-nama kesayangan Esa
        $filteredPets = array_filter($pets, function($pet) use ($favoritePets) {
            return in_array($pet['nama'], $favoritePets);
        });

        // Sorting
        usort($filteredPets, function($a, $b) use ($ascending) {
            return $ascending ? strcmp($a['nama'], $b['nama']) : strcmp($b['nama'], $a['nama']);
        });

        return $filteredPets;
    }

    // Fungsi untuk mengganti kucing Persia menjadi kucing Maine Coon
    function replaceCat($pets, $oldRas, $newRas) {
        foreach ($pets as &$pet) {
            if ($pet['ras'] === $oldRas && $pet['jenis'] === 'Kucing') {
                $pet['ras'] = $newRas;
            }
        }
        return $pets;
    }

    // Fungsi untuk menghitung jumlah hewan peliharaan Esa berdasarkan jenis
    function countPetsByType($pets) {
        $counts = [];
        foreach ($pets as $pet) {
            $counts[$pet['jenis']] = isset($counts[$pet['jenis']]) ? $counts[$pet['jenis']] + 1 : 1;
        }
        return $counts;
    }

    // Fungsi untuk mengecek hewan peliharaan Esa yang mengandung kata palindrome dan panjang string namanya
    function checkPalindromeNames($pets) {
        $palindromes = [];
        foreach ($pets as $pet) {
            if ($pet['nama'] === strrev($pet['nama'])) {
                $palindromes[] = [
                    "nama" => $pet['nama'],
                    "length" => strlen($pet['nama'])
                ];
            }
        }
        return $palindromes;
    }

    // Fungsi untuk menjumlahkan bilangan genap dari array
    function sumEvenNumbers($numbers) {
        $evenNumbers = array_filter($numbers, fn($num) => $num % 2 === 0);
        return [
            'even_numbers' => $evenNumbers,
            'sum' => array_sum($evenNumbers)
        ];
    }

    // Fungsi untuk mengecek apakah dua string adalah anagram
    function areAnagrams($str1, $str2) {
        $str1 = str_split(strtolower($str1));
        $str2 = str_split(strtolower($str2));
        sort($str1);
        sort($str2);
        return $str1 === $str2;
    }

    // Fungsi untuk memformat JSON
    function formatJson($inputFilePath, $outputFilePath) {
        $inputJson = json_decode(file_get_contents($inputFilePath), true);
        $formattedJson = json_encode($inputJson, JSON_PRETTY_PRINT);
        file_put_contents($outputFilePath, $formattedJson);
    }

    // Test Cases
    // Menambah Badak Jawa "Rino"
    addPet($pets, "Badak", "Jawa", "Rino", "Pekerja keras");

    // Mengambil hewan kesayangan Esa secara ascending dan descending
    $ascendingPets = getFavoritePets($pets, true);
    $descendingPets = getFavoritePets($pets, false);

    // Mengganti kucing Persia menjadi kucing Maine Coon
    $pets = replaceCat($pets, "Persia", "Maine Coon");

    // Menghitung jumlah hewan berdasarkan jenisnya
    $counts = countPetsByType($pets);

    // Mengecek hewan dengan nama palindrome
    $palindromes = checkPalindromeNames($pets);

    // Menjumlahkan bilangan genap dari array
    $numbers = [15, 18, 3, 9, 6, 2, 12, 14];
    $evenSum = sumEvenNumbers($numbers);

    // Mengecek apakah dua string adalah anagram
    $anagramTest = areAnagrams("listen", "silent");

    // Memformat JSON
    formatJson("assets/json/case.json", "assets/json/expectation.json");

    // Output untuk debugging
    echo "<h2>Data Hewan Peliharaan Esa</h2>";

    // Tabel HTML
    echo "<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>";

    echo "<table>";
    echo "<tr><th>Jenis</th><th>Ras</th><th>Nama</th><th>Karakteristik</th></tr>";

    foreach ($pets as $pet) {
        echo "<tr>";
        echo "<td>" . $pet['jenis'] . "</td>";
        echo "<td>" . $pet['ras'] . "</td>";
        echo "<td>" . $pet['nama'] . "</td>";
        echo "<td>" . $pet['karakteristik'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>
