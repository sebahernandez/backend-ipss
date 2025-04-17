<?php
/**
 * Datos hardcoded para ser utilizados como alternativa a la base de datos
 */

class FakeData {
    /**
     * Devuelve un array con datos de servicios hardcodeados
     */
    public static function getServicios() {
        return [
            [
                "id" => 1,
                "nombre" => [
                    "es" => "Desarrollo Web",
                    "en" => "Web Development"
                ],
                "descripcion" => [
                    "es" => "Creación de sitios web profesionales con tecnologías modernas",
                    "en" => "Creation of professional websites with modern technologies"
                ]
            ],
            [
                "id" => 2,
                "nombre" => [
                    "es" => "Marketing Digital",
                    "en" => "Digital Marketing"
                ],
                "descripcion" => [
                    "es" => "Estrategias de marketing para mejorar su presencia en línea",
                    "en" => "Marketing strategies to improve your online presence"
                ]
            ],
            [
                "id" => 3,
                "nombre" => [
                    "es" => "Diseño Gráfico",
                    "en" => "Graphic Design"
                ],
                "descripcion" => [
                    "es" => "Creación de identidad visual y materiales gráficos profesionales",
                    "en" => "Creation of visual identity and professional graphic materials"
                ]
            ],
            [
                "id" => 4,
                "nombre" => [
                    "es" => "Consultoría IT",
                    "en" => "IT Consulting"
                ],
                "descripcion" => [
                    "es" => "Asesoramiento experto para optimizar sus sistemas informáticos",
                    "en" => "Expert advice to optimize your IT systems"
                ]
            ],
            [
                "id" => 5,
                "nombre" => [
                    "es" => "Desarrollo de Aplicaciones Móviles",
                    "en" => "Mobile App Development"
                ],
                "descripcion" => [
                    "es" => "Creación de aplicaciones nativas para iOS y Android",
                    "en" => "Creation of native applications for iOS and Android"
                ]
            ]
        ];
    }
}
?>